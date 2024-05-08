<?php
require_once ('Functions/SideNavStudent.php');
require_once ('Functions/SideNavTeacher.php');
require_once ('Functions/SideNavAdmin.php');
function layout_sidenav($dbContext)
{
    ?>
    <input type="checkbox" id="active">
    <nav>
        <div class="content">
            <div class="info-admin">
                <div class="user-card">
                    <div class="user-image">
                        <img src="/images/blank-profile-picture.png" alt="Not logged in">
                    </div>
                    <div class="user-info">
                        <h2>Välkommen</h2>
                        <?php
                        if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
                            ?>
                            <a href="/users/login">
                                <i class="fas fa-sign-out-alt"></i>
                                Logga in
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="/users/logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Logga ut
                            </a>
                            <?php

                        }

                        ?>
                        <!-- <a href="/admin">
                        <i class="fas fa-sign-in-alt"></i>
                        Register
                    </a>-->
                    </div>

                </div>
            </div>
            <ul class="nav-item">
                <li>
                    <a href="/">
                        <span class="sidebar-icon"><i class="fas fa-house"></i></span>
                        <span class="sidebar-text"> Start</span>
                    </a>
                </li>
                <?php sideNavTeacher($dbContext); ?>

                <?php sideNavStudent($dbContext); ?>

                <?php sideNavAdmin($dbContext) ?>

                <li class="line-split"></li>
                <li>
                    <a href="/public">
                        <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                        <span class="sidebar-text"> Public</span>
                    </a>
                </li>

            </ul>
        </div>

    </nav>

    <?php
}
?>