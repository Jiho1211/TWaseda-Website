<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $nationality = sanitize_input($_POST['nationality']);
    $phone = sanitize_input($_POST['phone']);
    $message = sanitize_input($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color: red;">Please fill in all required fields.</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p style="color: red;">Invalid email address.</p>';
    } else {
        // Email details
        $to = "jihokwak1211@gmail.com"; // Replace with your actual email
        $subject = "New Inquiry from $name";
        $body = "Name: $name\nEmail: $email\nNationality: $nationality\nPhone: $phone\n\nMessage:\n$message";
        $headers = "From: $email";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            echo '<p style="color: green;">Thank you! Your message has been sent.</p>';
        } else {
            echo '<p style="color: red;">There was an issue sending your message. Please try again.</p>';
        }
    }
}

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>