<?php

declare(strict_types=1);

namespace App\Tests\Unit\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkers\SubHeaderWalker;
use App\Markdown\BlockTypeInterface;
use Codeception\Test\Unit;

class SubHeaderWalkerTest extends Unit
{
    public function testSubHeaderWalkerMetParagraph(): void
    {
        $walker = new SubHeaderWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH,
                [
                'Hello world',
                'Really hey!',
                ]
            )
        ]);
        $this->assertEquals([
            'Hello world',
            'Really hey!',
        ], $result[0]->getLines());
        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[0]->getType());
    }

    public function testSubHeaderWalkerMetOneSharpSign(): void
    {
        $walker = new SubHeaderWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH,
                [
                '# Hello world',
                'Really hey!',
                ]
            )
        ]);
        $this->assertEquals([
            '# Hello world',
            'Really hey!',
        ], $result[0]->getLines());
        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[0]->getType());
    }

    public function testSubHeaderWalkerMetTwoSharpSign(): void
    {
        $walker = new SubHeaderWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH,
                [
                '## Hello world',
                'Really hey!',
                ]
            )
        ]);
        $this->assertEquals([
            'Hello world',
            'Really hey!',
        ], $result[0]->getLines());
        $this->assertEquals(BlockTypeInterface::SUBHEADER, $result[0]->getType());
        $this->assertEquals(2, $result[0]->getLevel());
    }
}
