<?php
declare(strict_types=1);

final class One
{
    private $a;
    private $b;
    private $c;
    /** @var Two */
    private $two;

    public function __construct(Two $two)
    {
        $this->two = $two;
    }
    
    public function a()
    {
        return $this->a;
    }
    
    public function getA()
    {
        return $this->a;
    }
    
    public function b()
    {
        return $this->b;
    }
    
    public function getB()
    {
        return $this->b();
    }
    
    public function getAB()
    {
        return [$this->a, $this->getB()];
    }
    
    public function x()
    {
        return $this->two->x();
    }
    
    public function y()
    {
        return $this->two->y;
    }
    
    public function d()
    {
        // no-op
    }
}