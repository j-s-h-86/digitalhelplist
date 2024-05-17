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
    <main class="studentreaguest-main">

        <?php foreach ($getHelp as $helpRequest) { ?>
            <div class="studentrequest">
                <p> Namn</p>
                <li value><?php echo $helpRequest->StudentName ?>
                </li>
                <p> Mail </p>
                <li><?php echo $helpRequest->Email ?>
                </li>
                <p>Plats</p>
                <li><?php echo $helpRequest->Location ?>
                </li>
                <p>Fråga</p>
                <li><?php echo $helpRequest->Question ?>
                </li>
                <?php

                if ($helpRequest->Active) {
                    ?>

                    <button id="updateRequest" type="submit"
                        onclick="javascript:updateHelpRequest(<?php echo $helpRequest->Id ?>)">Lämna kön</button>
                    <?php
                } ?>
            </div>
            <?php
        }
        ?>

    </main>

</body>

</html>