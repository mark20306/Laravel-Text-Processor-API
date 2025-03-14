<?php

namespace App\Http\Controllers;

use App\Services\TextService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TextController extends Controller
{
    protected $textService;

    public function __construct(TextService $textService)
    {
        $this->textService = $textService;
    }
    public function process(Request $request)
    {
        try{
            $validated = $request->validate([
                'text' => 'required|string',
                'operations' => 'required|array'
            ]);

            $originalText = $validated['text'];
            $operations = $validated['operations'];

            $processedText = $this->textService->processText($originalText, $operations);

            return response()->json([
                'original_text' => $originalText,
                'processed_text' => $processedText
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->getMessage()
            ], 422);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => 'Invalid operation',
                'messages' => $e->getMessage()
            ], 400);
            
        } catch (Exception $e) {
            Log::error('Text Processing Error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Server Error',
                'messages' => 'Something went wrong'
            ], 500);
        }
        
    }
}
