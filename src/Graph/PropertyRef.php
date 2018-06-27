<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class PropertyRef implements Reference
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function resolveToPropertyNames(Graph $graph): array
    {
        return [$this->name];
    }
    
    public function toString(): string
    {
        return '$' . $this->name;
    }
}