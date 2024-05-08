<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ('Models/UserRoles.php');
require_once ('Models/UserDatabase.php');
require_once ('Models/HelpRequest.php');
require_once ('utils/Validator.php');

$dbContext = new DBContext();
$HelpRequest = new HelpRequest();
$message = "";
$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $dbContext->getUsersDatabase()->getAuth()->getUsername();
    $HelpRequest->StudentName = $_POST["StudentName"];
    $HelpRequest->Email = $email;
    $HelpRequest->Location = $_POST["Location"];
    $HelpRequest->Question = $_POST["Question"];
    $HelpRequest->Active = 1;


    $v->field('StudentName')->required()->min_len(3)->must_contain('a-z');
    $v->field('Location')->required()->min_len(3)->must_contain('a-z');
    $v->field('Question')->required()->min_len(10)->max_len(100)->must_contain('a-z');


    if ($v->is_valid()) {
        $dbContext->addHelpRequest(
            $HelpRequest->StudentName,
            $HelpRequest->Email,
            $HelpRequest->Location,
            $HelpRequest->Question,
            $HelpRequest->Active,
        );
        header("Location: /sentrequest");
        exit;

    }
    if (!preg_match("/^[a-zA-ZåÅäÄöÖ ]*$/", $HelpRequest->StudentName)) {
        $message = "Namn får endast innehålla bokstäver";
    }
    if (strlen($_POST["StudentName"]) < 3) {
        $message = "Namn måste innehålla minst 3 bokstäver";
    }
    if (!preg_match("/^[a-zA-ZåÅäÄöÖ ]*$/", $HelpRequest->Location)) {
        $message = "Plats får endast innehålla bokstäver";
    }
    if (strlen($_POST["Location"]) < 3) {
        $message = "Plats måste innehålla minst 3 bokstäver";
    }
    if (!preg_match("/^[a-zA-ZåÅäÄöÖ ]*$/", $HelpRequest->Question)) {
        $message = "Fråga får endast innehålla bokstäver";
    }
    if (strlen($_POST["Question"]) < 10) {
        $message = "Fråga måste innehålla minst 10 bokstäver";
    }
    if (strlen($_POST["Question"]) > 100) {
        $message = "Fråga får innehålla som mest 100 bokstäver";
    }
    ;

}
?>

<form method="POST">
    <input required value="<?php echo $HelpRequest->StudentName ?>" name="StudentName" placeholder="Namn" />

    <input required value="<?php echo $HelpRequest->Location ?>" name="Location" placeholder="Plats" />

    <input required value="<?php echo $HelpRequest->Question ?>" name="Question" placeholder="Ställ din fråga här" />

    <button type="submit">Ställ dig i kö</button>
    <?php


    ?>

</form>
<?php
echo $message;
?>