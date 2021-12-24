<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mailer {
 
    public function __construct() {
        $this->CI = &get_instance();
        require_once('PHPMailer/PHPMailerAutoload.php');
    }
 
    public function send_mail($toemail, $subject, $body, $FILES = array(), $cc = "") {

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $pharmacy_name = 'Pharmacy';
        
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host       = 'smtp.ipage.com';
		$mail->Port       = 465;
		$mail->Username   = 'info@dioniciofarmac.com.do';
		$mail->Password   = 'S0p0rt3.';
		$mail->SetFrom('info@dioniciofarmac.com.do', $pharmacy_name);
		$mail->AddReplyTo('info@dioniciofarmac.com.do', 'info@dioniciofarmac.com.do');
        
        if (!empty($FILES)) {
            if (isset($_FILES['files']) && !empty($_FILES['files'])) {
                $no_files = count($_FILES["files"]['name']);
                for ($i = 0; $i < $no_files; $i++) {
                    if ($_FILES["files"]["error"][$i] > 0) {
                        echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    } else {
                        $file_tmp = $_FILES["files"]["tmp_name"][$i];
                        $file_name = $_FILES["files"]["name"][$i];
                        $mail->AddAttachment($file_tmp, $file_name);
                    }
                }
            }
        }

        if ($cc != "") {
            $mail->AddCC($cc);
        }

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $body;
        $mail->AddAddress($toemail);
        // if ($mail->Send()) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

}
