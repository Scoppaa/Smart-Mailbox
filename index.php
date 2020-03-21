<!DOCTYPE html>
<html>

<head>
    <title>Smart Mailbox</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
    
<div class="form-style-5">
    <body style="text-align:center;">
        <h1>Smart Mailbox Application</h1>
        <p>Enter Your Phone Number:</p>
        <form method="post">
            <input type="tel" name="phonenumber" placeholder="10 Digit Phone Number" pattern="[0-9]{10}" required>
            <br>
            <p>Select Your Phone Carrier:</p>
            <select name="carrierdropdown" required>
                <option value=""></option>
                <option value="Verizon">Verizon</option>
                <option value="ATT">ATT</option>
                <option value="Sprint">Sprint</option>
                <option value="TMobile">T-Mobile</option>
            </select>
            <br><br>
            <input type="submit" name="submit" value="Start SmartMailbox">
        </form>

    </body>
</div>

</html>

<?php

	if(isset($_POST['submit'])) {
		//Appends phone carrier address to email address
        	if($_POST['carrierdropdown']=="Verizon"){
        	    //echo "DEBUG:Verizon";
        	    $carrier = "@vtext.com";
        	} elseif ($_POST['carrierdropdown']=="ATT"){
        	    //echo "DEBUG:ATT";
        	    $carrier = "@txt.att.net";
        	} elseif ($_POST['carrierdropdown']=="Sprint"){
        	    //echo "DEBUG:Sprint";
        	    $carrier = "@messaging.sprintpcs.com";
        	} elseif ($_POST['carrierdropdown']=="TMobile"){
        	    //echo "DEBUG:T-Mobile";
        	} else{
        	    echo "Break";
        	}

		//Gets users phone number from HTML form
		$phonenumber = $_POST['phonenumber'];
		//Opens notification script for editing
		$file = fopen('/home/pi/notification.sh','w');
		//Writes mail command to file appending phonenumber
		fwrite($file,'echo "Motion was detected in your Smart Mailbox!" | mail ' . $phonenumber . $carrier);
		//Closes file
		fclose($file);

		//Run Bash script notification.sh
		exec('bash /home/pi/notification.sh');

		//Runs python scripts
		//exec('python scriptname.py');
		//exec('python scriptname.py');

		//Alert Box
		//echo '<script type="text/javascript">';
		//echo 'alert("Alerts will be sent to " \. $phonenumber)';
		//echo '</script>';
	}
?>
