<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

interface Source
{
    public function getCode(): string;
}