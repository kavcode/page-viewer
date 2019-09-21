<?php declare(strict_types=1);

namespace App\Markdown;

class HtmlWriter
{
    /**
     * @param Block[] $blocks
     * @return string
     */
    public function write(array $blocks): string
    {
        $result = [];
        foreach ($blocks as $block) {
            switch ($block->getType()) {
                case BlockTypeInterface::PARAGRAPH:
                    $tag = 'p';
                    break;

                case BlockTypeInterface::HEADER:
                    $tag = 'h1';
                    break;

                case BlockTypeInterface::SUBHEADER:
                    $tag = 'h' . $block->getLevel();
                    break;

                case BlockTypeInterface::LIST_ITEM:
                    $tag = 'li';
                    break;

                case BlockTypeInterface::UNORDERED_LIST:
                    $tag = 'ul';
                    break;

                default:
                    throw new \RuntimeException(
                        "Undefined block type {$block->getType()}"
                    );

            }

            if ($block->hasChildren()) {
                $result[] = "<{$tag}>" . $this->write($block->getChildren()) . "</{$tag}>";
            } else {
                $result[] = "<{$tag}>" . implode('', $block->getLines()) . "</{$tag}>";
            }
        }

        return implode('', $result);
    }
}