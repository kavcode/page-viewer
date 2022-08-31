<?php

declare(strict_types=1);

namespace App\Tests\Unit\Markdown;

use App\Markdown\BlocksExtractor;
use Codeception\Test\Unit;

class BlocksExtractorTest extends Unit
{
    public function testExtractingBlocks(): void
    {
        $extractor = new BlocksExtractor();
        $result = $extractor->extract([
            'Foo'
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $result = $extractor->extract([
            ' ',
            'Foo',
            ' '
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $result = $extractor->extract([
            'Foo',
            ' '
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $result = $extractor->extract([
            ' ',
            'Foo',
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $result = $extractor->extract([
            ' ',
            'Foo',
            'Zoo'
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $this->assertEquals('Zoo', $result[0]->getLines()[1]);
        $result = $extractor->extract([
            ' ',
            'Foo',
            'Zoo',
            ' '
        ]);
        $this->assertCount(1, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $this->assertEquals('Zoo', $result[0]->getLines()[1]);
        $result = $extractor->extract([
            ' ',
            'Foo',
            ' ',
            'Zoo',
            ' '
        ]);
        $this->assertCount(2, $result);
        $this->assertEquals('Foo', $result[0]->getLines()[0]);
        $this->assertEquals('Zoo', $result[1]->getLines()[0]);
    }
}
