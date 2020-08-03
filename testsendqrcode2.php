

<!--<form enctype="multipart/form-data" method="POST" action="">

    <label>Your Name <input type="text" name="sender_name" /> </label>
    <label>Your Email <input type="email" name="sender_email" /> </label>
    <label>Subject <input type="text" name="subject" /> </label>
    <label>Message <textarea name="message"></textarea> </label>
    <label>Attachment <input type="file" name="attachment" /></label>
    <label><input type="submit" name="button" value="Submit" /></label>
</form>-->

<?php
//if ($_POST['button'] && isset($_FILES['attachment'])) {

    $from_email = 'cct3000@gmail.com'; //from mail, sender email addrress
    $recipient_email = 'meganet001@gmail.com'; //recipient email addrress
//Load POST data from HTML form
    $sender_name = "cct3000";
    $reply_to_email = "no-reply@ishin.my"; //sender email, it will be used in "reply-to" header
    $subject = "Test email with file attachment"; //subject for the email
    $message = "This is an email with file attacment and testing";


    /* Always remember to validate the form fields like this
      if(strlen($sender_name)<1)
      {
      die('Name is too short or empty!');
      }
     */

/*echo "list down \$_FILES contents<br> ";
print_r($_FILES);
echo "<br>";
//Get uploaded file data using $_FILES array
    $tmp_name = $_FILES['my_file']['tmp_name']; // get the temporary file name of the file on the server
    $name = $_FILES['my_file']['name'];  // get the name of the file
    $size = $_FILES['my_file']['size'];  // get size of the file for size validation
    $type = $_FILES['my_file']['type'];  // get type of the file
    $error = $_FILES['my_file']['error']; // get the error (if any)
//validate form field for attaching the file
    if ($file_error > 0) {
        die('Upload error or No files uploaded');
    }

//read from the uploaded file & base64_encode content
    $handle = fopen($tmp_name, "r");  // set the file handle only for reading the file
    $content = fread($handle, $size); // reading the file
    fclose($handle);                  // close upon completion
*/
## insert from https://stackoverflow.com/questions/12301358/send-attachments-with-php-mail
    $filename = 'qrcode_img.png';
    $path = './resource/img';
    $file = $path ."/".$filename;
echo "\$file = $file <br>";
    $content = file_get_contents($file);
    $encoded_content = chunk_split(base64_encode($content));

    $boundary = md5("random"); // define boundary with a md5 hashed value
//header
    $eol = PHP_EOL;
    $headers = "MIME-Version: 1.0" . $eol; // Defining the MIME version
    $headers .= "From:" . $from_email . $eol; // Sender Email
    $headers .= "Reply-To: " . $reply_to_email . $eol; // Email addrress to reach back
    $headers .= "Content-Type: multipart/mixed;" . $eol; // Defining Content-Type
    $headers .= "boundary = $boundary" . $eol; //Defining the Boundary
//plain text
    $body = "--$boundary" . $eol;
    $body .= "Content-Type: text/plain; charset=ISO-8859-1" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol . $eol;
    $body .= chunk_split(base64_encode($message));

//attachment
    $body .= "--$boundary" . $eol;
    $body .= "Content-Type: $file_type; name=" . $file_name . $eol;
    $body .= "Content-Disposition: attachment; filename=" . $file_name . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "X-Attachment-Id: " . rand(1000, 99999) . $eol . $eol;
    $body .= $encoded_content; // Attaching the encoded file with email

    $sentMailResult = mail($recipient_email, $subject, $body, $headers);

    if ($sentMailResult) {
        echo "File Sent Successfully.";
        // unlink($name); // delete the file after attachment sent.
    } else {
        die("Sorry but the email could not be sent.
                    Please go back and try again!");
    }
//}
