<?php
// Include configuration and survey class
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey.class.php";
session_start();
// Initialize response array
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $created_by = $_SESSION['user_id'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $exp_date = $_POST['exp_date'] ?? null;
    if (!$exp_date) {
        $date = new DateTime();
        $date->modify('+2 weeks');
        $exp_date = $date->format('Y-m-d'); // Format as 'YYYY-MM-DD'
    }
    $hash_id = bin2hex(random_bytes(8)); // 16-character random string

    // Validate inputs
    if (!$created_by || !$title || !$exp_date || !$hash_id) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required!';
    } else {
        // Call the create method from the survey class
        try {
            $isCreated = Survey::create($created_by, $title, $description, $exp_date, $hash_id);
            if ($isCreated) {
                $response['status'] = 'success';
                $response['message'] = 'Survey created successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to create survey!';
            }
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method!';
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
