<?php

function sideNavTeacher($dbContext)
{

    if ($dbContext->getUsersDatabase()->getAuth()->hasRole(UserRoles::TEACHER)) {
        ?>
        <li class="line-split"></li>
        <li>
            <a href="/courses">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Kurser</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/schedule">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Schema</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/helplist">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Kölista för handledning</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/profile">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Min profil</span>
            </a>
        </li>
        <?php
    }

}

?>