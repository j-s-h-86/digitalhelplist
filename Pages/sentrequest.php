<?php
require 'vendor/autoload.php';
require_once ("Models/Database.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/sidenav.php");
require_once ("Pages/layout/footer.php");




$dbContext = new DBContext();




layout_header("MI:s digitala hjälplista");
?>


<body>


    <!------------------sidenav-------------->
    <?php
    layout_sidenav($dbContext);
    ?>
    <!------------------main-------------->
    <main>
        Din förfrågan är skickad du har plats ... i kön.
    </main>

</body>

</html>