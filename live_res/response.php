<?php

require "vendor/autoload.php";

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->text)) {
    $text = $data->text;

    try {
        $client = new Client("GEMINI_API_KEY"); # replace with you API key (GEMINI)

        $response = $client->geminiPro()->generateContent(new TextPart($text));

        // Return the generated text as a JSON response
        echo json_encode(['text' => $response->text()]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No text provided.']);
}
?>
