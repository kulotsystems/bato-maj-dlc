<?php

require_once 'Contingent.php';

class DrumLyreCorps extends Contingent
{
    public function __construct($id)
    {
        parent::__construct('dlc', $id);
    }
}
