<?php

declare(strict_types=1);

namespace App\Markdown;

class WordSplitter
{
    public function splitOnWordsAndMarks(string &$line): array
    {
        $result = [];
        $currentWord = [];
        $len = strlen($line);
        for ($i = 0; $i < $len; $i++) {
            $char = $line[$i];
            if (
                in_array($char, [':', '.', '?', '!'], true)
                && $i + 1 < $len
                && preg_match('/\s/', $line[$i + 1])
            ) {
                $result[] = implode('', $currentWord);
                $currentWord = [];
                $result[] = $char;
                $i++;
                continue;
            }

            if (
                in_array($char, [','], true)
                && $i + 1 < $len
                && !preg_match('/[0-9]/', $line[$i + 1])
            ) {
                $result[] = implode('', $currentWord);
                $currentWord = [];
                $result[] = $char;
                if (preg_match('/\s/', $line[$i + 1])) {
                    $i++;
                }

                continue;
            }

            if (preg_match('/\s/', $char) && $currentWord) {
                $result[] = implode('', $currentWord);
                $currentWord = [];
                continue;
            }

            $currentWord[] = $char;
        }

        return $result;
    }

    /**
     * @param string[] $words
     * @return string
     */
    public function collectLine(array $words): string
    {
        $lineCollector = [];
        $lastWord = '';
        foreach ($words as $word) {
            if (in_array($word, [',', '.', ':', '?', '!'], true) && $lastWord) {
                $lineCollector[] = $lastWord . $word;
                $lastWord = '';
                continue;
            }

            if ($lastWord) {
                $lineCollector[] = $lastWord;
            }

            $lastWord = $word;
        }

        if ($lastWord) {
            $lineCollector[] = $lastWord;
        }

        return implode(' ', $lineCollector);
    }
}
