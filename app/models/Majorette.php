<?php

require_once 'Contingent.php';

class Majorette extends Contingent
{
    public function __construct($id)
    {
        parent::__construct('maj', $id);
    }
}
