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
        <?php foreach ($getHelp as $helpRequest) { ?>
            <br>
            <li value><?php echo $helpRequest->StudentName ?>
            </li>
            <li><?php echo $helpRequest->Email ?>
            </li>
            <li><?php echo $helpRequest->Location ?>
            </li>
            <li><?php echo $helpRequest->Question ?>
            </li>
            <li><?php echo $helpRequest->Active ?>
            </li>
            <li><?php echo $helpRequest->Id ?>
            </li>

            <?php

            if ($helpRequest->Active) {
                ?>

                <button id="updateRequest" type="submit"
                    onclick="javascript:updateHelpRequest(<?php echo $helpRequest->Id ?>)">Lämna kön</button>
                <?php
            } ?>
            <?php
        }
        ?>
        </ul>
    </main>

</body>

</html>