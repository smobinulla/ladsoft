<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Check required fields
    if (empty($name) || !$email || empty($subject) || empty($message)) {
        header("Location: ../mail-error.html");
        exit;
    }

    // Prepare email
    $to = "info@ladsoft.com"; // Replace with your email address
    $email_subject = "New Message from $name: $subject";
    $email_body = "
        Name: $name\n
        Email: $email\n
        Phone: $phone\n
        Subject: $subject\n
        Message: $message\n
    ";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        header("Location: ../mail-success.html");
    } else {
        header("Location: ../mail-error.html");
    }
    exit;
} else {
    // Redirect for invalid request method
    header("Location: ../index.html");
    exit;
}
?>
