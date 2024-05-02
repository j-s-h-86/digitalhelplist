<?php
class UserRoles
{

    const STUDENT = \Delight\Auth\Role::REVIEWER;
    const TEACHER = \Delight\Auth\Role::COORDINATOR;
    const ADMINISTRATOR = \Delight\Auth\Role::ADMIN;

    private function __construct()
    {
    }

}