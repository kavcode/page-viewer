<?php

declare(strict_types=1);

namespace App\Domain\Documents;

class HeadlineExtractor
{
    private const WAIT_TAG = 0;
// waiting for <h1 combination
    private const WAIT_CONTENT = 1;
// tag is opened, waiting for closing >
    private const READ_CONTENT = 2;
// waiting for </h1> combination

    public function extract(string $text): ?string
    {
        $len = strlen($text);
        $content = '';
        $state = self::WAIT_TAG;

        for ($i = 0; $i < $len; $i++) {
            $ch = $text[$i];
            switch ($ch) {
                case '<':
                    if ($state === self::WAIT_TAG) {
                        if ($this->isHeadlineBeginning($text, $i, $len)) {
                            $state = self::WAIT_CONTENT;
                            $i += 2;
                            continue 2;
                        }
                    }

                    if ($state === self::READ_CONTENT) {
                        if ($this->isHeadlineBeginning($text, $i, $len)) {
                        // This means we've come across something like this <h1>..<h1
                            return null;
                        }

                        if ($this->isHeadlineEnding($text, $i, $len)) {
                            return $content;
                        } else {
                            $content .= $ch;
                            continue 2;
                        }
                    }

                    if ($state === self::WAIT_CONTENT) {
// This means we've come across something like this <h1...<
                        return null;
                    }


                    break;
                case '>':
                    if ($state === self::WAIT_CONTENT) {
                        $state = self::READ_CONTENT;
                        continue 2;
                    }

                    if ($state === self::READ_CONTENT) {
                        $content .= $ch;
                    }


                    break;
                default:
                    if ($state === self::READ_CONTENT) {
                        $content .= $ch;
                    }
            }
        }
        return null;
    }

    private function isHeadlineBeginning(&$buffer, int $currentPos, int $len): bool
    {
        return $currentPos + 2 < $len
            && strtolower($buffer[$currentPos + 1]) === 'h'
            && $buffer[$currentPos + 2] === '1';
    }

    private function isHeadlineEnding(&$buffer, int $currentPos, int $len): bool
    {
        return $currentPos + 4 < $len
            && $buffer[$currentPos + 1] === '/'
            && strtolower($buffer[$currentPos + 2]) === 'h'
            && $buffer[$currentPos + 3] === '1'
            && $buffer[$currentPos + 4] === '>';
    }
}
