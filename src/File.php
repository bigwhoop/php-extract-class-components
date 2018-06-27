<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

final class File implements Source
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        if (!is_readable($path)) {
            throw new \InvalidArgumentException("Path '{$path}' must be readable");
        }
        
        $this->path = $path;
    }
    
    public function getCode(): string
    {
        return file_get_contents($this->path);
    }
}