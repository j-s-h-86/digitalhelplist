<?php
require_once ("Models/Database.php");
$Id = $_GET['id'] ?? "";


$dbContext = new DBContext();
$updateHelpRequest = $dbContext->updateHelpRequest($Id);

// $
echo json_encode($updateHelpRequest);

?>