<?php
require 'vendor/autoload.php';
require_once ("Models/Database.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/sidenav.php");
require_once ("Pages/layout/footer.php");

$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$q = $_GET['q'] ?? "";
$pageNo = $_GET['pageNo'] ?? "1";
$pageSize = $_GET['pageSize'] ?? "20";


$dbContext = new DBContext();



// $mail = new PHPMailer\PHPMailer\PHPMailer(true);
// $mail->isSMTP();
// $mail->Host = 'smtp.ethereal.email';
// $mail->SMTPAuth = true;
// $mail->Username = 'raheem2@ethereal.email';
// $mail->Password = 'PdZkY2RvfRyZGrgNAT';
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

// $mail->From = "stefans@superdupershop.com"; 
// $mail->FromName = "Stefans SuperShop"; //To address and name 
// $mail->addAddress("bill.gates@microsoft.com"); //Address to which recipient will reply 
// $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
// $mail->isHTML(true); 
// $mail->Subject = "Bara liten test"; 
// $mail->Body = "<h2>Hej</h2>, Vilket kul nyhetsbrev <b>fdsfds</b>";
// $mail->send();


// $mail->From = "stefans@superdupershop.com"; 
// $mail->FromName = "Stefans SuperShop"; //To address and name 
// $mail->addAddress("kalle@hfdsdg7ewqygwqu.com"); //Address to which recipient will reply 
// $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
// $mail->isHTML(true); 
// $mail->Subject = "Bara liten test2"; 
// $mail->Body = "<h2>Hej2</h2>, Vilket kul nyhetsbr2ev <b>fdsfds</b>";
// $mail->send();



layout_header("MI:s digitala hjälplista");
?>


<body>


    <!------------------sidenav-------------->
    <?php
    layout_sidenav($dbContext);
    ?>
    <!------------------main-------------->
    <main>
        <?php
        if ($dbContext->getUsersDatabase()->getAuth()->hasRole(UserRoles::TEACHER)) {
            echo "<p>Här är lärarens kurser.</p>";
        }
        ?>
        <?php
        if ($dbContext->getUsersDatabase()->getAuth()->hasRole(UserRoles::STUDENT)) {
            echo "<p>Här är elevens kurser.</p>";
        }
        ?>
        <?php
        if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
            echo "<p>Du måste vara inloggad för att se dina kurser.</p>";
        }
        ?>
    </main>

</body>

</html>