<?php
// PHP script to handle and process the incoming JSON request
// Set content type to JSON for response
header('Content-Type: application/json');

// Read the incoming JSON request
$input = file_get_contents('php://input');

// Decode the JSON to an associative array
$data = json_decode($input, true);

// Check if JSON decoding was successful
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid JSON data"]);
    exit;
}



http_response_code(200); // OK
echo json_encode(["message" => "Survey responses processed successfully", "responses" => $responses]);
exit;
?>
