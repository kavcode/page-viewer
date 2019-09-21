<?php declare(strict_types=1);

namespace App\Tests\Unit\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkers\UnorderedListWalker;
use App\Markdown\BlockTypeInterface;
use Codeception\Test\Unit;

class UnorderedListWalkerTest extends Unit
{
    public function testUnorderedListWalkerMetParagraph(): void
    {
        $walker = new UnorderedListWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH, [
                'Hello world',
                'Really hey!',
            ])
        ]);

        $this->assertEquals([
            'Hello world',
            'Really hey!',
        ], $result[0]->getLines());

        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[0]->getType());
    }

    public function testUnorderedListWalkerMetOneListItem(): void
    {
        $walker = new UnorderedListWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Hello world',
                'Really hey!',
            ])
        ]);


        $this->assertEquals(BlockTypeInterface::UNORDERED_LIST, $result[0]->getType());

        $liBlock = $result[0]->getChildren()[0];
        $this->assertStringContainsString('Hello world', $liBlock->getLines()[0]);
        $this->assertStringContainsString('Really hey!', $liBlock->getLines()[1]);

    }

    public function testUnorderedListWalkerMetTwoListItemsBetweenParagraphs(): void
    {
        $walker = new UnorderedListWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH, [
                'Foo',
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Hello world',
                'Really hey!',
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Second item'
            ]),
            new Block(
                BlockTypeInterface::PARAGRAPH, [
                'Bar',
            ])
        ]);

        $this->assertCount(3, $result);
        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[0]->getType());

        $firstLiBlock = $result[1]->getChildren()[0];
        $secondLiBlock = $result[1]->getChildren()[1];

        $this->assertStringContainsString('Hello world', $firstLiBlock->getLines()[0]);
        $this->assertStringContainsString('Really hey!', $firstLiBlock->getLines()[1]);
        $this->assertStringContainsString('Second item', $secondLiBlock->getLines()[0]);

        $this->assertEquals(BlockTypeInterface::UNORDERED_LIST, $result[1]->getType());

        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[2]->getType());
    }

    public function testUnorderedListWalkerWithManyEntries(): void
    {
        $walker = new UnorderedListWalker();
        $result = $walker->walk([
            new Block(
                BlockTypeInterface::PARAGRAPH, [
                'Foo',
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Hello world',
                'Really hey!',
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Second item'
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Third item'
            ]),
            new Block(
                BlockTypeInterface::PARAGRAPH, [
                'Bar',
            ]),
            new Block(
                BlockTypeInterface::LIST_ITEM, [
                'Ending list item',
            ]),
        ]);

        $this->assertCount(4, $result);
        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[0]->getType());

        $firstLiBlock = $result[1]->getChildren()[0];
        $secondLiBlock = $result[1]->getChildren()[1];
        $thirdLiBlock = $result[1]->getChildren()[2];

        $this->assertStringContainsString('Hello world', $firstLiBlock->getLines()[0]);
        $this->assertStringContainsString('Really hey!', $firstLiBlock->getLines()[1]);
        $this->assertStringContainsString('Second item', $secondLiBlock->getLines()[0]);
        $this->assertStringContainsString('Third item', $thirdLiBlock->getLines()[0]);

        $this->assertEquals(BlockTypeInterface::UNORDERED_LIST, $result[1]->getType());

        $this->assertEquals(BlockTypeInterface::PARAGRAPH, $result[2]->getType());

        $this->assertEquals(BlockTypeInterface::UNORDERED_LIST, $result[3]->getType());
    }
}