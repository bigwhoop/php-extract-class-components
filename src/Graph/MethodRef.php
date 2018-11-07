<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class MethodRef implements Reference
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function resolveToPropertyNames(Graph $graph): array
    {
        $props = [];
        foreach ($graph->getRefsForMethod($this->name) as $refOfThisMethod) {
            foreach ($refOfThisMethod->resolveToPropertyNames($graph) as $prop) {
                $props[$prop] = $prop;
            }
        }
        
        return array_values($props);
    }
    
    public function toString(): string
    {
        return $this->name . '()';
    }

    public function getName(): string
    {
        return $this->name;
    }
}