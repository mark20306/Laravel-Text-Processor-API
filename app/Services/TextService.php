<?php

namespace App\Services;

use InvalidArgumentException;

class TextService
{
    public function processText(string $text, array $operations): string
    {
        $result = $text;

        foreach ($operations as $operation) {
            switch(strtolower($operation)) {
                case 'reverse':
                    $result = $this->reverse($result);
                    break;
                case 'uppercase':
                    $result = $this->uppercase($result);
                    break;
                case 'lowercase':
                    $result = $this->lowercase($result);
                    break;
                case 'remove_spaces':
                    $result = $this->removeSpaces($result);
                    break;
                default:
                    throw new InvalidArgumentException("Unknown operation: {$operation}");
            }
        }

        return $result;
    }

    private function reverse(string $text): string
    {
        return strrev($text);
    }
    private function uppercase(string $text): string
    {
        return mb_strtoupper($text);
    }
    private function lowercase(string $text): string
    {
        return mb_strtolower($text);
    }
    private function removeSpaces(string $text): string
    {
        return str_replace(' ', '', $text);
    }
}