<?php

function sideNavStudent($dbContext)
{

    if ($dbContext->getUsersDatabase()->getAuth()->hasRole(UserRoles::STUDENT)) {
        ?>
        <li class="line-split"></li>
        <li>
            <a href="/student">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Kurser</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/student">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Schema</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/student">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Skicka handledningsförfrågan</span>
            </a>
        </li>
        <li class="line-split"></li>
        <li>
            <a href="/student">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Min profil</span>
            </a>
        </li>
        <?php
    }

}

?>