<?php
require 'vendor/autoload.php';
require_once ("Models/Database.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/sidenav.php");
require_once ("Pages/layout/footer.php");

$dbContext = new DBContext();
$Email = $dbContext->getUsersDatabase()->getAuth()->getUsername();
$getHelp = $dbContext->getHelpRequest($Email);
?>

<?php
layout_header("MI:s digitala hjälplista");
?>

<script>
    async function updateHelpRequest(id) {
        const updateHelpRequest = await (await fetch(`/updateHelpRequest?id=${id}`))
        document.getElementById("updateRequest").disabled = true;
        header("Location: /helplist");
        exit;
    }
</script>

<body>


    <!------------------sidenav-------------->
    <?php
    layout_sidenav($dbContext);
    ?>
    <!------------------main-------------->
    <main>
        <p>Din förfrågan är skickad!</p>

    </main>

</body>

</html>