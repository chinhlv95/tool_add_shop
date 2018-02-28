<?php

require_once './MC/Controller/SettingController.php';
// set_error_handler('exceptions_error_handler');

$corporation = $_POST['corporation'];
$fileName    = $_FILES['fileToUpload']['name'];
$target_path = './';
$target_path = $target_path . basename( $_FILES['fileToUpload']['name']); 

if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path)) {
    echo 'The file '.  basename( $_FILES['fileToUpload']['name']). 
    ' has been uploaded';
} else {
    echo 'There was an error uploading the file, please try again!';
}
	echo "</br>";

// function exceptions_error_handler($severity, $message, $filename, $lineno) {
//   if (error_reporting() == 0) {
//     echo $message;
//   }
//   if (error_reporting() & $severity) {
//     throw new ErrorException($message, 0, $severity, $filename, $lineno);
//   }
// }

$control = new SettingController();
$control->setShop($corporation, $target_path);
