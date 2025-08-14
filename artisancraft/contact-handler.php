<?php
session_start();
require_once 'config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);

    // Validate input
    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
    } else {
        try {
            if (create_contact_message($name, $email, $subject, $message)) {
                $response['success'] = true;
                $response['message'] = 'Thank you for your message! We will get back to you soon.';
            } else {
                $response['message'] = 'Failed to send message. Please try again.';
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred. Please try again.';
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 