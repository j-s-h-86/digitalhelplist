<?php
require ('Models/Database.php');
require_once ('Models/HelpRequest.php');
require_once ('layout/header.php');
require_once ('layout/sidenav.php');



$dbContext = new dbContext();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Id = $_GET['id'] ?? "";
}

?>
<?php
layout_header("Helplist")
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
    <?php
    layout_sidenav($dbContext);
    ?>
    <main>
        <ul>

            <?php foreach ($dbContext->getAllHelpRequest() as $helpRequest) { ?>
                <br>
                <?php var_dump($helpRequest) ?>
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

                <button id="updateRequest" type="submit"
                    onclick="javascript:updateHelpRequest(<?php echo $helpRequest->Id ?>)">Help</button>
                <?php
            }
            ?>
        </ul>
    </main>
</body>