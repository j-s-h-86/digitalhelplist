<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ('Models/UserRoles.php');
require_once ('Models/UserDatabase.php');
require_once ('Models/HelpRequest.php');

$dbContext = new DBContext();
$HelpRequest = new HelpRequest();
$message = "";

// $v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $HelpRequest->StudentName = $_POST["StudentName"];
    $HelpRequest->Email = $_POST["Email"];
    $HelpRequest->Location = $_POST["Location"];
    $HelpRequest->Question = $_POST["Question"];


    // $v->field('Email')->required()->email();
    // if ($v->is_valid()) {
    $dbContext->addHelpRequest(
        $HelpRequest->StudentName,
        $HelpRequest->Email,
        $HelpRequest->Location,
        $HelpRequest->Question,
        $HelpRequest->Active,
    );
    header("Location: /users/login");
    exit;
} else {
    $message = "FIXA FEL";
}

// }

?>

<form method="POST">
    <input value="<?php echo $HelpRequest->StudentName ?>" name="StudentName" placeholder="Namn" />
    <input value="<?php echo $HelpRequest->Email ?>" name="Email" placeholder="Epost" />
    <input value="<?php echo $HelpRequest->Location ?>" name="Location" placeholder="Plats" />
    <input value="<?php echo $HelpRequest->Question ?>" name="Question" placeholder="Vad har du för problem?" />
    <button type="submit">Ställ dig i kö</button>
</form>