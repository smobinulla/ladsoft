<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));
    
    // Check for required fields
    if (empty($name) || !$email || empty($subject) || empty($message)) {
        // Redirect to an error page or display a message
        header("Location: ../mail-error.html");
        exit;
    }

    // Build the email message
    $email_message = "
        Name: $name\n
        Email: $email\n
        Phone: $phone\n
        Subject: $subject\n
        Message: $message\n
    ";

    // Set the recipient and headers
    $to = "info@ladsoft.com";
    $email_subject = "New Message from $name: $subject";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_message, $headers)) {
        // Redirect to success page
        header("Location: ../mail-success.html");
    } else {
        // Redirect to an error page
        header("Location: ../mail-error.html");
    }
} else {
    // If the request is not POST, redirect to the homepage
    header("Location: ../index.html");
    exit;
}
?>