<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextProcessingTest extends TestCase
{
    public function test_it_process_text_with_valid_operations(): void
    {
        $payload = [
            'text' => 'Hello World',
            'operations' => ['uppercase', 'remove_spaces']
        ];

        $response = $this->postJson('/api/text/process', $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'original_text' => 'Hello World',
            'processed_text' => 'HELLOWORLD'
        ]);
    }

    public function test_it_validates_missing_text_field(): void
    {
        $payload = [
            'operations' => ['reverse']
        ];

        $response = $this->postJson('/api/text/process', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }

    public function test_it_returns_validation_error_when_operations_is_invalid(): void
    {
        $payload = [
            'text' => 'Hello',
            'operations' => ['invalid_op']
        ];

        $response = $this->postJson('/api/text/process', $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['operations.0']);
    }

    public function test_it_processes_multiple_operations_in_order(): void
    {
        $payload = [
            'text' => 'Hello World',
            'operations' => ['reverse', 'lowercase', 'remove_spaces']
        ];

        $response = $this->postJson('/api/text/process', $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'original_text' => 'Hello World',
            'processed_text' => 'dlrowolleh'
        ]);
    }
}
