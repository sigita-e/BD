<!DOCTYPE html>
<?php

// Include db_connect file
require "database.php";

// Define variables and initialize with empty values
$password = $email = "";
$login_err = $lg_email_err = $lg_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //when user clicks Login button
        require "login.php";
}

include "header.php";
?>

    <title>UDHS apvienība | ienākt</title>

<style>


</style>

<body>

<div class="page-wrapper">

<div class="container">
    <div class="row">
        <h1 class="h1-body-text">Apvienības biedru autentifikācija</h1>

            <div class="col-sm-6 centered col-sm-offset-3">

            <div class="light_form">
                <section class="inner_form" id="login_form">
                    <hr>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                    <div class="row">
                    <div class="col-sm-6 centered col-sm-offset-3">

                        <div <?php echo (!empty($lg_email_err)) ? "has-error" : ""; ?>>
                            <label for="email" class="label-login">
                                <span>E-pasts:<!--<span class="text-orange">*</span>--></span>
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-login" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                                </svg>
                                </span>
                            </label>
                            <input type="email" name="email" id="email" value="<?= $email ?>">
                            <span class="help-block"><?= $lg_email_err ?></span>
                        </div>

                        <div <?php echo (!empty($lg_password_err)) ? "has-error" : ""; ?>>
                            <label for="password" class="label-login">
                                <span>Parole:<!--<span class="text-orange">*</span>--></span>
                                <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-login" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                </svg>
                                </span></label>
                            <input type="password" name="password" id="password"><br>
                            <span class="help-block"><?= $lg_password_err ?></span>
                            <span><?= $login_err ?></span>
                        </div>

                        </div>    
                        </div>
                        <br>
                        <hr>
                        <button class="btn btn-primary" name="login">Ienākt</button>
                    </form>
                </section>

            </div>

            </div>

    </div>
</div>

</div>

<?php require "footer.php";?>

</body>
</html>