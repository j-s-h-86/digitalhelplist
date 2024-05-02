<?php

class HelpRequest
{
    public $Id;
    public $StudentName;
    public $Email;
    public $Location;
    public $Question;
    public $Active;

    function __construct()
    {
        $this->Active = true;
    }

}