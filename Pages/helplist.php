<?php
require ('Models/Database.php');
require_once ('Models/HelpRequest.php');
require_once ('Models/Teachers.php');
require_once ('layout/header.php');
require_once ('layout/sidenav.php');

$dbContext = new dbContext();

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
    <?php
    layout_sidenav($dbContext);
    ?>
    <main class="helplist-main">
        <?php $UserId = $dbContext->getUsersDatabase()->getAuth()->getUserId();

        $teacher = $dbContext->getTeacherById($UserId) ?>

        <?php

        foreach ($dbContext->getAllHelpRequest() as $helpRequest) {
            $course = $dbContext->getCourseById($helpRequest->CourseID);
            if ($teacher->CourseID === $course->Id) {

                ?>
                <div class="helplist">
                    <p>Namn</p>
                    <li value><?php echo $helpRequest->StudentName ?>
                    </li>
                    <li>
                    </li>
                    <p>Mail</p>
                    <li><?php echo $helpRequest->Email ?>
                    </li>
                    <p>Kurs</p>
                    <li><?php echo $course->CourseName ?>
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
                            onclick="javascript:updateHelpRequest(<?php echo $helpRequest->Id ?>)">Help</button>
                        <?php
                    } else {
                        ?>
                        <button disabled>Done</button>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        }
        ?>
    </main>
</body>