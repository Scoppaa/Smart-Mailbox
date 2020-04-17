<!DOCTYPE html>
<html>

<head>
    <title>Smart Mailbox</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<?php
    
    //***********************
    //  Connect To Database
    //***********************
    global $conn; 
    $servername = "localhost";
    $username = "root";        
    $password = "root";     
    $dbname = "smart_mailbox";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //Get phonenumber from database
    $dbp = "SELECT `pnumber` FROM phonenumber WHERE `pid` = 1";
    $result = $conn->query($dbp);
    $row = $result->fetch_assoc();
        
    //***********************
    //  Start SmartMailbox
    //***********************
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
		    $carrier = "@tmomail.net";
        	} else{
        	    echo "Break";
        	}
    
		//Gets users phone number from HTML form
		$phonenumber = $_POST['phonenumber'];
		//Opens notification script for editing
		$file = fopen('/home/pi/project/notification.sh','w');
		//Writes mail command to file appending phonenumber
		fwrite($file,'echo "Motion was detected in your Smart Mailbox!" | mail ' . $phonenumber . $carrier);
		//Closes file
		fclose($file);
    
    
        //Inserts User Phone Number into Database
        $sql = "UPDATE phonenumber SET pnumber = '$phonenumber' WHERE pid = 1";
        
        //Run Query and Debug if Neccessary
        if (mysqli_query($conn, $sql)) {
            //echo "Record updated successfully";
        } else {
            //echo "Error updating record: " . mysqli_error($conn);
        }
        
		//***********************
        //  Run Python Script
        //***********************
		exec('node /home/pi/project/blynkconnect.js');
		//shell_exec('python /home/pi/project/MotionNotification.py 2>&1 &');
    }
?>

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
        <!--Displays Current Phone Number Entered-->
        <label>Current Phone Number: </label> <?php echo $row["pnumber"]; ?>
    </body>
</div>

</html>
