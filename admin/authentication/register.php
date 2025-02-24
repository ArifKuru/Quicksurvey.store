<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/services/smtp/smtp_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $pdo;

    // Initialize response array
    $response = array();

    // Get form data
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($company_name && $email && $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Generate a 12-character random verification hash ID
        $verificationHashId = generateVerificationHash();

        try {
            // Add the user to the database with the verification hash ID
            $sql = "INSERT INTO users (company_name, email, password, verificationHashId) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$company_name, $email, $hashedPassword, $verificationHashId])) {
                // Success response
                $response['status'] = 'success';
                $response['message'] = 'Registration successful! Please check your email for verification.';
                $response["mail"] = "$email";

                // Send verification email
                sendVerificationEmail($email, $verificationHashId);
            } else {
                // Error response
                $response['status'] = 'error';
                $response['message'] = 'An error occurred during registration!';
            }
        } catch (PDOException $e) {
            // Catch and return the database error
            $response['status'] = 'error';
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        // Missing data response
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all fields!';
    }

    // Set the response header to JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Function to generate a 12-character random verification hash ID
function generateVerificationHash() {
    return bin2hex(random_bytes(6)); // Generates a 12-character string (12 = 6 bytes)
}

// Function to send verification email
function sendVerificationEmail($email, $verificationHashId) {
    $subject = "Verify Your Email";

    // HTML email content
    $message = '
    <html>
    <head>
        <title>Verify Your Email</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
            }
            .email-container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 30px;
                box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            }
            .email-header {
                text-align: center;
                padding-bottom: 20px;
            }
            .email-header img {
                width: 120px;
            }
            .email-body {
                font-size: 16px;
                color: #333;
                line-height: 1.5;
                padding-bottom: 20px;
            }
            .button {
                background-color: #666090;
                color: #ffffff;
                padding: 15px 25px;
                text-align: center;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                font-size: 18px;
                margin-top: 20px;
            }
            .footer {
                text-align: center;
                font-size: 14px;
                color: #777;
                margin-top: 30px;
            }
            .footer a {
                color: #666090;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <img src="https://quicksurvey.store/public/logo.png" alt="Company Logo">
            </div>
            <div class="email-body">
                <h2>Hello,</h2>
                <p>Thank you for registering with us. Please click the button below to verify your email address and complete your registration.</p>
                <a href="https://quicksurvey.store/register/verify?hash=' . $verificationHashId . '" class="button" style="color: white">Verify My Email</a>
            </div>
            <div class="footer">
                <p>If you did not register for an account, please disregard this email.</p>
                <p>For support, contact us at <a href="mailto:support@quicksurvey.store">support@quicksurvey.store</a></p>
            </div>
        </div>
    </body>
    </html>';

    // Send email
    sendMail($email, $message, $subject);
}
?>
