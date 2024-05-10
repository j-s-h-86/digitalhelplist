<?php

require 'vendor/autoload.php';
require_once ('models/Database.php');
require_once ('utils/Validator.php');
require_once ('Pages/layout/header.php');
require_once ('Pages/layout/sidenav.php');
require_once ('Pages/layout/footer.php');

$token = $_GET['token'];
$selector = $_GET['selector'];
$dbContext = new dbContext;
$password = "";
$passwordAgain = "";
$error = false;
$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['newPassword'];
    $passwordAgain = $_POST['newPasswordAgain'];

    try {
        $dbContext->getUsersDatabase()->getAuth()->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);
    } catch (\Exception $e) {
        $message = "Ngt gick fel";
    }


}

?>
<?php layout_header("Byt lösenord");
layout_sidenav($dbContext);
?>

<body>
    <main>
        <div class="row">
            <p>
                <?php if ($error) {
                    echo "<script type='text/javascript'>alert('$message');</script>" ?>
                    <?php
                }
                ?>

            <div class="row">

                <div class="col-md-12">
                    <div class="newsletter">
                        <p><strong>&nbsp;New password</strong></p>
                        <form method="POST" action="/passwordreset">
                            <input type="input" type="text" hidden name="token" value="<?php echo $token ?>">
                            <input type="input" type="text" hidden name="selector" value="<?php echo $selector ?>">
                            <input class="input" type="password" name="newPassword" placeholder="Enter New Password"
                                value="<?php echo $password ?>">
                            <br />
                            <br />
                            <input class="input" type="password" name="newPasswordAgain"
                                placeholder="Repeat New Password" value="<?php echo $passwordAgain ?>">
                            <br />
                            <br />
                            <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i>
                                Skicka</button>
                            <br />
                        </form>

                    </div>
                </div>
            </div>


        </div>


        </p>
        <?php layout_footer() ?>
    </main>
</body>