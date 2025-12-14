<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. RECIPIENT EMAIL
    $to = "bjbaas@bjbaas.net";

    // 2. SANITIZE & COLLECT INPUTS
    $firstName = htmlspecialchars(strip_tags(trim($_POST['first-name'])));
    $lastName  = htmlspecialchars(strip_tags(trim($_POST['last-name'])));
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone     = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $subject   = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message   = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // 3. VALIDATE EMAIL
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please go back and try again.";
        exit;
    }

    // 4. CONSTRUCT EMAIL CONTENT
    $email_subject = "New Contact Form Submission: $subject";
    
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $firstName $lastName\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "------------------------------\n";
    $email_body .= "Message:\n$message\n";

    // 5. EMAIL HEADERS
    // 'From' should ideally be an email address from your own domain (e.g., noreply@bjbaas.net) 
    // to prevent the email from landing in your Spam folder.
    $headers = "From: noreply@bjbaas.net\r\n"; 
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 6. SEND EMAIL
    if (mail($to, $email_subject, $email_body, $headers)) {
        // Success: You can redirect to a "Thank You" page or print a message
        echo "Thank you! Your message has been sent successfully.";
    } else {
        // Failure
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    echo "There was a problem with your submission, please try again.";
}
?>
