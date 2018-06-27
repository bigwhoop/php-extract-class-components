<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class MethodRef implements Reference
{
    /** @var string */
    private $method;

    public function __construct(string $method)
    {
        $this->method = $method;
    }
    
    public function resolveToPropertyNames(Graph $graph): array
    {
        $props = [];
        foreach ($graph->getRefsForMethod($this->method) as $refOfThisMethod) {
            foreach ($refOfThisMethod->resolveToPropertyNames($graph) as $prop) {
                $props[$prop] = $prop;
            }
        }
        
        return array_values($props);
    }
    
    public function toString(): string
    {
        return $this->method . '()';
    }
}