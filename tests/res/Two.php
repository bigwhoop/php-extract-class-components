<?php
declare(strict_types=1);

final class Two
{
    public $y;
    private $x;
    
    public function x()
    {
        return $this->x;
    }
    
    public function z()
    {
        // no-op
    }
}