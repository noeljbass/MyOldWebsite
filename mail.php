<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Check for empty inputs
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "All fields are required. Please fill in all fields.";
        exit;
    }

	// Check if honeypot is filled
    if (!empty($honeypot)) {
        echo "Spam detected. Your submission has been rejected.";
        exit;
    }

	// Basic validation for phone number input
	if (!preg_match('/^\d{1,10}$/', $phone)) {
        echo "Invalid phone number. It must be numeric and no longer than 10 characters.";
        exit;
    }

	$userAnswer = trim($_POST['captcha']);
    $correctAnswer = trim($_POST['captcha-answer']); 

    // Validate CAPTCHA
    if ($userAnswer !== $correctAnswer) {
        error_log("CAPTCHA answer is incorrect.");
        echo "CAPTCHA answer is incorrect. Please try again.";
        exit;
    }

    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $from = "mail@noeljbass.me";
    $headers .= 'From: '.$name.'<'.$from.'>' . "\r\n"; 

        $text = "Message Body:" . $message . "<br>Name:" . $name . "<br>Phone Number:" . $phone . "<br>Email:" . $email . "\n\n";
        $recipient = "mail@noeljbass.me";


        if (mail($recipient, 'New NoelJBass.Me Website Inquiry', $text, $headers)) {
           ?>
           <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>NoelJBass Contact Success</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	font-family: 'Varela Round', sans-serif;
}
.modal-confirm {		
	color: #434e65;
	width: 525px;
}
.modal-confirm .modal-content {
	padding: 20px;
	font-size: 16px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	background: #47c9a2;
	border-bottom: none;   
	position: relative;
	text-align: center;
	margin: -20px -20px 0;
	border-radius: 5px 5px 0 0;
	padding: 35px;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 36px;
	margin: 10px 0;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px; 
}
.modal-confirm .close {
	position: absolute;
	top: 15px;
	right: 15px;
	color: #fff;
	text-shadow: none;
	opacity: 0.5;
}
.modal-confirm .close:hover {
	opacity: 0.8;
}
.modal-confirm .icon-box {
	color: #fff;		
	width: 95px;
	height: 95px;
	display: inline-block;
	border-radius: 50%;
	z-index: 9;
	border: 5px solid #fff;
	padding: 15px;
	text-align: center;
}
.modal-confirm .icon-box i {
	font-size: 64px;
	margin: -4px 0 0 -4px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #eeb711 !important;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border-radius: 30px;
	margin-top: 10px;
	padding: 6px 20px;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #eda645 !important;
	outline: none;
}
.modal-confirm .btn span {
	margin: 1px 3px 0;
	float: left;
}
.modal-confirm .btn i {
	margin-left: 1px;
	font-size: 20px;
	float: right;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>
</head>
<body>
<div class="text-center">
 	<div class="modal-dialog modal-confirm border border-bottom-1">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>
				
			</div>
			<div class="modal-body text-center">
				<h4>Great!</h4>	
				<p>Email have successfully sent</p>
				<a href='../' class="btn btn-success" data-dismiss="modal"><span>Go Back</span> <i class="material-icons">&#xE5C8;</i></a>
			</div>
		</div>
	</div>    
</body>
</html>                            
           <?PHP
        } else {
            error_log("Error sending the email");
            echo "Error sending the email.";
        }
    }
 
else {
    error_log("Invalid request method");
    echo "Invalid request method.";
}
?>
