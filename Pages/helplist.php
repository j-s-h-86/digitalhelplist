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

                <?php

                if ($helpRequest->Active) {
                    ?>
                    <button type="submit" <?php $dbContext->updateHelpRequest($Id) ?>><a
                            href='helplist?id=<?php echo $helpRequest->Id ?>'>Help</a></button>
                    <?php

                } else {
                    ?>
                    <button disabled>Done</button>
                    <?php
                }
                ?>
                <?php
            }
            ?>
        </ul>
    </main>
</body>