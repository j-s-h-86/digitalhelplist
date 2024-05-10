<?php
use Delight\Auth\Auth;

require 'vendor/autoload.php';
require_once ('models/Database.php');
require_once ('utils/Validator.php');
require_once ('Pages/layout/header.php');
require_once ('Pages/layout/sidenav.php');
require_once ('Pages/layout/footer.php');

$dbContext = new DbContext();
$username = "";
$v = new Validator($_POST);
$error = false;
$emailSent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $v->field('username')->required()->email();
    if ($username) {
        try {
            $dbContext->getUsersDatabase()->getAuth()->forgotPassword($_POST['username'], function ($selector, $token) {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.ethereal.email';
                $mail->SMTPAuth = true;
                $mail->Username = 'douglas.kassulke37@ethereal.email';
                $mail->Password = 'T3Mu5t4YY7PmVPnYPJ';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->From = "stefans@superdupershop.com";
                $mail->FromName = "Hello"; //To address and name 
                $mail->addAddress($_POST['username']); //Address to which recipient will reply 
                $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
                $mail->isHTML(true);
                $mail->Subject = "Reset password";
                $url = 'http://localhost:8000/resetpassword?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $mail->Body = "Hej, klicka på <a href='$url'>$url</a></i> för att ändra ditt lösenord";
                $mail->send();

            });

            $emailSent = true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $error = true;
            $message = "Ej korrekt email";
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $error = true;
            $message = "För många försök";
        } catch (\Delight\Auth\AttemptCancelledException $e) {
            $error = true;
            $message = "Avbrutet försök";
        } catch (\Delight\Auth\UnknownUsernameException $e) {
            $error = true;
            $message = "Okänd användare";
        }
    }
}

?>
<?php layout_header("Glömt lösenord");
layout_sidenav($dbContext);
?>

<body>
    <main>
        <div class="row">
            <p>

            <div class="row">
                <?php
                if ($emailSent) {
                    ?>
                    <h3>Email skickat till <?php
                    echo $username
                        ?></h3>
                    <?php
                }
                ?>
                <?php
                if ($error) {
                    echo "<script type='text/javascript'>alert('$message');</script>" ?>
                    <?php
                }
                ?>
                <div class="col-md-12">
                    <div class="newsletter">
                        <p><strong>&nbsp;Reset password</strong></p>
                        <form method="POST">
                            <input class="input" type="email" name="username" placeholder="Enter Your Email"
                                value="<?php echo $username ?>">
                            <br />
                            <p class="alert"><?php echo $v->get_error_message('username'); ?></p>
                            <br />

                            <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i>
                                Skicka</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </p>
        <?php layout_footer() ?>
    </main>
</body>