<?php
// Include configuration and survey class
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/responses.class.php";

// Initialize response array
$response = array();

try {
    // Check if user is logged in
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $response['status'] = 'error';
        $response['message'] = 'User not logged in!';
    } else {
        // Fetch surveys using getAll method
        $surveys = Survey::getAll($user_id);

        // Add response count for each survey
        foreach ($surveys as &$survey) {
            $survey_id = $survey['id'];
            $survey['response_count'] = Responses::getCountResponses($survey_id);
        }

        $response['status'] = 'success';
        $response['data'] = $surveys;
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
