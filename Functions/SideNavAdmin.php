<?php
function sideNavAdmin($dbContext)
{

    if ($dbContext->getUsersDatabase()->getAuth()->hasRole(UserRoles::ADMINISTRATOR)) {
        ?>
        <li class="line-split"></li>
        <li>
            <a href="/users/register">
                <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                <span class="sidebar-text">Registrera</span>
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