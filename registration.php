<?php
/**
 * Created by PhpStorm.
 * User: dastan
 * Date: 10/4/16
 * Time: 4:28 PM
 */
require_once "templates/header.php";
?>

    <?php

    $registered = FALSE;

    if (isset($_POST["submitButton"])) {

        $user = new UserController();

        // Language titles
        $user->TITLES = $VALIDATION;
        $user->REGISTRATION_TITLES = $REGISTRATION;

        $user->email = $_POST["inputEmail"];

        $user->password = filter_var($_POST["inputPassword"], FILTER_SANITIZE_STRING);
        $user->password_repeat = filter_var($_POST["inputPasswordRepeat"], FILTER_SANITIZE_STRING);

        $user->firstname = filter_var($_POST["inputFirstname"], FILTER_SANITIZE_STRING);
        $user->lastname = filter_var($_POST["inputLastname"], FILTER_SANITIZE_STRING);
        $user->photo = $_FILES["inputPhoto"];

        $user->day_of_birth = filter_var($_POST["selectDay"], FILTER_SANITIZE_NUMBER_INT);
        $user->month_of_birth = filter_var($_POST["selectMonth"], FILTER_SANITIZE_STRING);
        $user->year_of_birth = filter_var($_POST["selectYear"], FILTER_SANITIZE_NUMBER_INT);

        $user->gender = filter_var($_POST["inputGender"], FILTER_SANITIZE_STRING);

        // TRUE - Registration, FALSE - Authorization
        $user->isRegistering = TRUE;

        $register = $user->register();

        if ($register) {
            $registered = TRUE;
        }
    }

    ?>
    <form class="form-horizontal form-registration" method="post" action="registration" enctype="multipart/form-data">
        <fieldset>

            <!-- Legend -->
            <legend><?php render_title(); ?></legend>

            <!-- Email -->
            <div class="form-group">
                <label for="inputEmail" class="col-lg-4 control-label"><?= $TITLES["email"] ?></label>
                <div class="col-lg-5">
                    <input type="text" name="inputEmail" class="form-control" id="inputEmail" placeholder="<?= $TITLES["email"] ?>" value="<?php render_input_value("inputEmail", $registered); ?>" required autofocus>
                </div>
                <span id="inputEmailHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="inputPassword" class="col-lg-4 control-label"><?= $TITLES["password"] ?></label>
                <div class="col-lg-5">
                    <input type="password" name="inputPassword" class="form-control" id="inputPassword" placeholder="<?= $TITLES["password"] ?>" value="<?php render_input_value("inputPassword", $registered); ?>" required>
                </div>
                <span id="inputPasswordHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Repeat Password -->
            <div class="form-group">
                <label for="inputPasswordRepeat" class="col-lg-4 control-label"><?= $TITLES["password_repeat"] ?></label>
                <div class="col-lg-5">
                    <input type="password" name="inputPasswordRepeat" class="form-control" id="inputPasswordRepeat" placeholder="<?= $TITLES["password_repeat"] ?>" value="<?php render_input_value("inputPasswordRepeat", $registered); ?>" required>
                </div>
                <span id="inputPasswordRepeatHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Firstname -->
            <div class="form-group">
                <label for="inputFirstname" class="col-lg-4 control-label"><?= $TITLES["firstname"] ?></label>
                <div class="col-lg-5">
                    <input type="text" name="inputFirstname" class="form-control" id="inputFirstname" placeholder="<?= $TITLES["firstname"] ?>" value="<?php render_input_value("inputFirstname", $registered); ?>" required>
                </div>
                <span id="inputFirstnameHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Lastname -->
            <div class="form-group">
                <label for="inputLastname" class="col-lg-4 control-label"><?= $TITLES["lastname"] ?></label>
                <div class="col-lg-5">
                    <input type="text" name="inputLastname" class="form-control" id="inputLastname" placeholder="<?= $TITLES["lastname"] ?>" value="<?php render_input_value("inputLastname", $registered); ?>" required>
                </div>
                <span id="inputLastnameHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Photo -->
            <div class="form-group">
                <label for="inputPhoto" class="col-lg-4 control-label"><?= $TITLES["photo"] ?></label>
                <div class="col-lg-5">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input type="file" name="inputPhoto" class="form-control" id="inputPhoto" />
                </div>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label class="col-lg-4 control-label"><?= $TITLES["gender"] ?></label>
                <div class="col-lg-5">
                    <div class="radio">
                        <label id="labelGenderMale">
                            <input type="radio" name="inputGender" id="inputGenderMale" value="male" <?php render_radio_checked("inputGender", "male", $registered); ?> required>
                            <?= $TITLES["male"] ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label id="labelGenderFemale">
                            <input type="radio" name="inputGender" id="inputGenderFemale" value="female" <?php render_radio_checked("inputGender", "female", $registered); ?> required>
                            <?= $TITLES["female"] ?>
                        </label>
                    </div>
                </div>
                <span id="inputGenderHint" class="hints control-label col-lg-3"></span>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="select" class="col-lg-4 control-label"><?= $TITLES["date_of_birth"] ?></label>
                <div class="col-lg-5 form-dob">
                    <div class="row">

                        <!-- Day -->
                        <div class="col-md-3">
                            <label for="selectDay"><?= $TITLES["day"] ?></label>
                            <select class="form-control select-dob" name="selectDay" id="selectDay" required>
                                <?php
                                    $selected = get_input_value("selectDay");
                                    render_days_of_month($selected, $registered);
                                ?>
                            </select>
                        </div>

                        <!-- Month -->
                        <div class="col-md-5">
                            <label for="selectMonth"><?= $TITLES["month"] ?></label>
                            <select class="form-control select-dob" name="selectMonth" id="selectMonth" required>
                                <?php
                                    $selected = get_input_value("selectMonth");
                                    render_months($selected, $registered);
                                ?>
                            </select>
                        </div>

                        <!-- Year -->
                        <div class="col-md-4">
                            <label for="selectYear"><?= $TITLES["year"] ?></label>
                            <select class="form-control select-dob" name="selectYear" id="selectYear" required>
                                <?php
                                    $selected = get_input_value("selectYear");
                                    render_years($selected, $registered);
                                ?>
                            </select>
                        </div>

                    </div> <!-- .row -->
                </div>
                <span id="selectHint" class="hints control-label col-lg-3"></span>
            </div> <!-- Date of Birth -->

            <!-- Submit and Clean Buttons -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-4">
                    <button type="reset" class="btn btn-default"><?= $TITLES["clean"] ?></button>
                    <button type="submit" name="submitButton" id="submitButton" class="btn btn-primary"><?= $TITLES["register"] ?></button>
                </div>
            </div>

        </fieldset>
    </form>

<?php
require_once "templates/footer.php";
?>
