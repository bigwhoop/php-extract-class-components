<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Tests;

use Bigwhoop\PhpClassComponentsExtractor\Extractor;
use Bigwhoop\PhpClassComponentsExtractor\File;
use Bigwhoop\PhpClassComponentsExtractor\TextFormatter;
use PHPUnit\Framework\TestCase;

final class TextFormatterTest extends TestCase
{
    /** @test */
    public function i_can_get_components_of_a_single_class(): void
    {
        $extractor = new Extractor();
        $graph = $extractor->extract(new File(__DIR__ . '/../res/Two.php'));
        
        $expected = <<<'TXT'
Component #1
  $x
  x()

Component #2
  $y

Component #3
  z()
TXT;
        
        $this->assertSame($expected, (new TextFormatter())->format($graph));
    }
    
    /** @test */
    public function i_can_get_components_of_a_class_with_dependencies(): void
    {
        $extractor = new Extractor();
        $graph = $extractor->extract(new File(__DIR__ . '/../res/One.php'));
        
        $expected = <<<'TXT'
Component #1
  $a
  $b
  a()
  b()
  getA()
  getAB()
  getB()

Component #2
  $two
  x()
  y()

Component #3
  $c

Component #4
  d()
TXT;
        
        $this->assertSame($expected, (new TextFormatter())->format($graph));
    }
}