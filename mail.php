<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Molimo pokušajte ponovo.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "matija.gudlin@kosinus.hr";

        // Set the email subject.
        $subject = "Nova poruka od $name";

        // Build the email content.
        $email_content = "Ime: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Naslov: $subject\n\n";
        $email_content .= "Poruka:\n$message\n";

        // Build the email headers.
        $email_headers = "Od: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Hvala vam! Vaša poruka je poslana.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Došlo je do pogreške kod slanja poruke.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Došlo je do pogreške kod slanja poruke, pokušajte ponovo.";
    }

?>
