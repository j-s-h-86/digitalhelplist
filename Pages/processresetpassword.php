<?php

require 'vendor/autoload.php';
require_once ('models/Database.php');


$dbContext = new dbContext;
$message = "";
$password = $_POST['newPassword'];
$token = $_POST['token'];
$selector = $_POST['selector'];
$passwordAgain = $_POST['newPasswordAgain'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($password != $passwordAgain) {
        echo 'Det uppstod ett fel. Lösenord ej bytt.';
        $error = true;
    }
    if ($password === $passwordAgain) {
        try {

            $dbContext->getUsersDatabase()->getAuth()->resetPassword($_POST['selector'], $_POST['token'], $_POST['newPassword']);
            $message = 'Password has been reset';
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>

            <a href="/users/login">Logga in</a>

            <?php
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\ResetDisabledException $e) {
            die('Password reset is disabled');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

    }

}

?>