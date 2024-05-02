<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ('Models/UserRoles.php');
require_once ('Models/UserDatabase.php');

$dbContext = new DBContext();

?>

<form method="POST">
    <input name="name" placeholder="Namn" />
    <input name="email" placeholder="Epost" />
    <input name="location" placeholder="Plats" />
    <input name="question" placeholder="Vad har du för problem?" />
    <button type="submit">Ställ dig i kö</button>
</form>