<?php

$siteOwnersEmail = 'info@macsxperts.com';

if ($_POST) {
    
    $name            = trim(stripslashes($_POST['contactName']));
    $email           = trim(stripslashes($_POST['contactEmail']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));
    $contact_phone   = trim(stripslashes($_POST['contactPhone']));
    
    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please enter a valid email address.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    // Subject
    $subject = "Contacted via Macsxperts.com";

    
    // Set Message
    $message .= "Name: " . $name . "<br />";
    $message .= "Email: " . $email . "<br />";
    $message .= "Phone: " . $contact_phone . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    
    // Set From: header
    $from = $name . " <" . $email . ">";
    
    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
    
    if (!$error) {
        
        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);
        
        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }
        
    } # end if - no validation error
    
    else {
        
        $response = (isset($error['name'])) ? $error['name'] . "\n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "\n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "\n" : null;
        
        echo $response;
        
    } # end if - there was a validation error
    
}

?>