<?php

namespace Tests\Unit;

use App\Services\TextService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TextServiceTest extends TestCase
{
    protected TextService $textService;

    public function setUp(): void
    {
        parent::setUp();

        $this->textService = new TextService();
    }

    public function test_reverses_the_text(): void
    {
        $text = 'Hello';
        $operations = ['reverse'];

        $result = $this->textService->processText($text, $operations);

        $this->assertEquals('olleH', $result);
    }

    public function test_uppercases_the_text(): void
    {
        $text = 'hello';
        $operations = ['uppercase'];

        $result = $this->textService->processText($text, $operations);

        $this->assertEquals('HELLO', $result);
    }

    public function test_lowercases_the_text(): void
    {
        $text = 'HELLO';
        $operations = ['lowercase'];

        $result = $this->textService->processText($text, $operations);

        $this->assertEquals('hello', $result);
    }

    public function test_removes_spaces_in_the_text(): void
    {
        $text = 'Hello World';
        $operations = ['remove_spaces'];

        $result = $this->textService->processText($text, $operations);

        $this->assertEquals('HelloWorld', $result);
    }

    public function test_processes_multiple_operations_in_correct_order(): void
    {
        $text = 'Hello World';
        $operations = ['reverse', 'lowercase', 'remove_spaces'];

        $result = $this->textService->processText($text, $operations);

        $this->assertEquals('dlrowolleh', $result);
    }

    public function test_throws_an_exception_for_invalid_operation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown operation: invalid_op');

        $text = 'Hello';
        $operations = ['invalid_op'];

        $this->textService->processText($text, $operations);
    }
}
