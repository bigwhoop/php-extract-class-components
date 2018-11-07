<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Tests;

use Bigwhoop\PhpClassComponentsExtractor\Extractor;
use Bigwhoop\PhpClassComponentsExtractor\File;
use Bigwhoop\PhpClassComponentsExtractor\Formatting\JsonFormatter;
use PHPUnit\Framework\TestCase;

final class JsonFormatterTest extends TestCase
{
    /** @test */
    public function i_can_get_components_of_a_single_class(): void
    {
        $extractor = new Extractor();
        $graph = $extractor->extract(new File(__DIR__ . '/../res/Two.php'));
        
        $this->assertEquals([
            [
                'methods' => ['x()'],
                'properties' => ['$x'],
            ],
            [
                'methods' => [],
                'properties' => ['$y'],
            ],
            [
                'methods' => ['z()'],
                'properties' => [],
            ],
        ], json_decode((new JsonFormatter())->format($graph), true));
    }
    
    /** @test */
    public function i_can_get_components_of_a_class_with_dependencies(): void
    {
        $extractor = new Extractor();
        $graph = $extractor->extract(new File(__DIR__ . '/../res/One.php'));
        
        $this->assertEquals([
            [
                'properties' => ['$a', '$b'],
                'methods' => ['a()', 'b()', 'getA()', 'getAB()', 'getB()'],
            ],
            [
                'properties' => ['$two'],
                'methods' => ['x()', 'y()'],
            ],
            [
                'properties' => ['$c'],
                'methods' => [],
            ],
            [
                'properties' => [],
                'methods' => ['d()'],
            ],
        ], json_decode((new JsonFormatter())->format($graph), true));
    }
}