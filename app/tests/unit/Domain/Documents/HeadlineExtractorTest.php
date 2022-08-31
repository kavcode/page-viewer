<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Documents;

use App\Domain\Documents\HeadlineExtractor;
use Codeception\Test\Unit;

class HeadlineExtractorTest extends Unit
{
    public function testExtractingHeadline(): void
    {
        $extractor = new HeadlineExtractor();
        $this->assertEquals('Hello', $extractor->extract('<h1>Hello</h1>'), '#1');
        $this->assertEquals('Hello', trim($extractor->extract('<h1>Hello
                </h1>')), '#2');
        $this->assertEquals('Hello', $extractor->extract('<div class="headline">
                    <h1>Hello</h1>
                 </div>'), '#3');
        $this->assertEquals('Hello', $extractor->extract('<H1>Hello</H1>'), '#4');
        $this->assertEquals('Hello', $extractor->extract('<h1 class="foo" data-greeting="dynamic">Hello</h1>'), '#5');
        $this->assertEquals(null, $extractor->extract('<h1><h1>Hello</h1></h1>'), '#6');
        $this->assertEquals(null, $extractor->extract('<h1 <h1>Hello</h1></h1>'), '#6.1');
        $this->assertEquals('<em>Hello</em>', $extractor->extract('<h1><em>Hello</em></h1>'), '#7');
        $this->assertEquals('Hello', $extractor->extract('<h1>Hello</h1><h1>John</h1>'));
        $this->assertEquals('Hello', $extractor->extract('<h1>Hello</h1>
                 <h1>John</h1>
                 <h1>Smith</h1>'), '#8');
    }
}
