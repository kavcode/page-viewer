<?php

declare(strict_types=1);

namespace App\Tests\Unit\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkers\HeaderWalker;
use App\Markdown\BlockTypeInterface;
use Codeception\Test\Unit;

class HeaderWalkerTest extends Unit
{
    public function testHeaderWalkerMetParagraph(): void
    {
        $walker = new HeaderWalker();
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

    public function testHeaderWalkerMetHeadlineByDash(): void
    {
        $walker = new HeaderWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH,
                [
                'Hello world',
                '-------- ',
                ]
            )
        ]);
        $this->assertEquals([
            'Hello world'
        ], $result[0]->getLines());
        $this->assertEquals(BlockTypeInterface::HEADER, $result[0]->getType());
    }

    public function testHeaderWalkerMetHeadlineByEquation(): void
    {
        $walker = new HeaderWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH,
                [
                'Hello world',
                '==== ',
                ]
            )
        ]);
        $this->assertEquals([
            'Hello world'
        ], $result[0]->getLines());
        $this->assertEquals(BlockTypeInterface::HEADER, $result[0]->getType());
    }
}
