#! /usr/local/bin/php -e
<?php
/**
 * @FileName: sendHtmlEmail.php
 * @Version: 1.0
 * @Auther: WangKilin
 * @Email: wangkilin@126.com
 * @Desc: The script is used to send AD mail of HTML type.
 */

error_reporting(E_ALL); // report all errors
set_time_limit(0); // set script running non-timeout

if (!is_file('./inc/emailAdConfig.ini')) { // config file not ready
    die("The config file is missing!\n");
}

$config = @parse_ini_file('./inc/emailAdConfig.ini', true);

if (!is_array($config) || !isset($config['GLOBAL_CONFIG'], $config['EMAIL_CONFIG'], $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'], $config['SMTP_' . $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'] . '_CONFIG'])) { // it is a bad config file
    die ("The config is abnormal!\n");
}


$emailDir = $config['GLOBAL_CONFIG']['EmailFileDir']; // the path which stores the files includding email address list. (one address per line)
$pointerDir = $config['GLOBAL_CONFIG']['PointerFileDir']; // the path which stores the pointer files. The pointer file will be of same name with email address file. As sending email, the pointer file stores the position of current sending in email address file.
$numberOfEmailsPerSending = $config['SMTP_' . $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'] . '_CONFIG']['NumberOfEmailsPerSending']; // how many emails each mail will be sent to.
$numberOfSendings = $config['SMTP_' . $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'] . '_CONFIG']['NumberOfSendings']; // how many times of sending that script will excute during its running 
$periodOfSendingBreak = $config['SMTP_' . $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'] . '_CONFIG']['PeriodOfSendingBreak']; // To make SMTP server rest for a while as sending email.

if (is_file($config['EMAIL_CONFIG']['Subject'])) { // handle email subject
    $config['EMAIL_CONFIG']['Subject'] = file_get_contents($config['EMAIL_CONFIG']['Subject']);
}

if (is_file($config['EMAIL_CONFIG']['Body'])) { // handle email body
    $config['EMAIL_CONFIG']['Body'] = file_get_contents($config['EMAIL_CONFIG']['Body']);
}

if (is_file($config['EMAIL_CONFIG']['AltBody'])) { // handle email altbody
    $config['EMAIL_CONFIG']['AltBody'] = file_get_contents($config['EMAIL_CONFIG']['AltBody']);
}

require(dirname(__FILE__) . '/inc/class.phpmailer.php'); // include php mailer class

/**
 * Send email to specified email list
 *
 * @param array $emailList Email address list
 *
 * @return boolean
 */
function sendEmail($emailList)
{
    global $config;

    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->PluginDir = './inc/';
    $smtpConfig = $config['SMTP_' . $config['GLOBAL_CONFIG']['WhichSmtpConfigToBeUsed'] . '_CONFIG'];
    $mail->Host = $smtpConfig['SmtpHost']; // SMTP servers
    $mail->SMTPAuth = true;  // Turn on SMTP authentication
    $mail->Username = $smtpConfig['UserName']; // Mandatory only if Authentcation is on
    $mail->Password = $smtpConfig['Password']; // Mandatory only if Authentcation is on
    $mail->Port = $smtpConfig['Port'];
	   if ($config['GLOBAL_CONFIG']['Debug']) {
		      $mail->SMTPDebug = 2;
	   }
    $mail->FromName = $config['EMAIL_CONFIG']['FromName'];
    $mail->From = $smtpConfig['FromAddress']; // Sender of the mail
    $mail->to = $emailList;

    $mail->IsHTML(true);                               // send as HTML
    $mail->Subject = $config['EMAIL_CONFIG']['Subject'] . date(' -- Y-m-d H:i:s') . ' (AD)'; // get the subject of email
    $mail->Body = str_replace(array('{$emailDate}', '{$emailSigner}')
                            , array(date('Y-m-d H:i:s'), $config['EMAIL_CONFIG']['FromName'])
                            , $config['EMAIL_CONFIG']['Body']); // get the content of email
    $mail->AltBody = $config['EMAIL_CONFIG']['AltBody']; // get the alt content of email

    $TimeZone = $config['GLOBAL_CONFIG']['TimeZone'];
    $HardcodeDate = false;
    if ($TimeZone) {
        switch(substr($TimeZone, 0, 1)) {
            case '-': $sign = '+'; break;
            default:
            case '+': $sign = '-'; break;
        }
        if ((int)substr($TimeZone, 1) < 10) {
            $ServerTimeZone = $sign . '0' . substr($TimeZone, 1) . '00';
        } else {
            $ServerTimeZone = $sign . substr($TimeZone, 1) . '00';
        }

        $mail->AddCustomHeader("Date:" . date("D, j M Y H:i:s", time() - date("Z")) . " " . $ServerTimeZone);
    }

    $mail->Send();
	   if ($mail->ErrorInfo) { // check if error happened during sending
		      echo $mail->ErrorInfo . "\n";
		      return false;
    }

    return true;
}



if (!is_dir($pointerDir)) { // Store the pointer files. 
    mkdir($pointerDir, 0755);
}
if (!is_writable($pointerDir)) { // pointer dir not writable
    die('File pointer dir is not writable');
}

if (is_dir($emailDir)) {
    if ($edh = opendir($emailDir)) {
        $emailList = array(); // cache the email addresses for per sending
        $emailCount = 0; // to keep the number of email addresses to be sent email to
        $sendingCount = 0; // to keep how many times script sent

        while (($emailFile = readdir($edh)) !== false) {
            if ($emailFile=='.' || $emailFile=='..') {
                continue;
            }
            if(!($efh = fopen($emailDir . '/' . $emailFile, 'r'))) {
                die ('Open email file failed **** ' . $emailDir . '/' . $emailFile);
            }

            // open the pointer file to check the position at which last sending is
            if($pfh = @fopen($pointerDir . '/' . $emailFile, 'r')) {
                $pointer = fgets($pfh);
                fclose($pfh);
                if ($pointer && $pointer!='EOF') { // go on sending 
                    fseek($efh, $pointer);
                } elseif($pointer=='EOF') { // means this email address file is sent completely.
                    fclose($efh);
                    continue;
                }
            }
            
            while(!feof($efh)) {
                // prepare the email list for sending
                $emailAddress = fgets($efh);
                if (strpos($emailAddress, '@')) {
                    $emailList[$emailCount++] = array(trim($emailAddress));
                }

                if ($emailCount>=$numberOfEmailsPerSending) { // the email list is ready, we send email now..
                    if ($sendFlag = sendEmail($emailList)) { // this sending is successful. Keep the position for next sending
                        echo "###### " . date('Y-m-d H:i:s') . "  --- Batch " . ($sendingCount+1) . " sent \n";
                        $pointer = ftell($efh);
                        if($pfh = fopen($pointerDir . '/' . $emailFile, 'w')) {
                            fwrite($pfh, $pointer);
                            fclose($pfh);
                        }
					               }
                    $emailList = array();
                    //var_dump($emailList);
                    $sendingCount++;
                    if ($sendingCount>=$numberOfSendings) { // already sent so many times. And reach the limit. Just quit.
                        break 2;
                    } else { // this loop is finished. go on next sending.
                        $emailCount = 0;
                    }
                    if (true===$sendFlag && $periodOfSendingBreak) { // this sending works well. Let SMTP server have a rest.
                        sleep($periodOfSendingBreak);
                    }
                } else {// go on readding file to get email address
                    continue;
                }
            }

            if (count($emailList) && sendEmail($emailList)) { // the email address file is already EOF, but we still have email list to be sent 
                echo "###### " . date('Y-m-d H:i:s') . "  --- $emailFile is sent completely!\n";
                if($pfh = fopen($pointerDir . '/' . $emailFile, 'w')) {
                    fwrite($pfh, 'EOF');
                    fclose($pfh);
                }
            } else if (feof($efh)) {
                if($pfh = fopen($pointerDir . '/' . $emailFile, 'w')) {
                    fwrite($pfh, 'EOF');
                    fclose($pfh);
                }
            }
            fclose($efh);
        }
        closedir($edh);
    } else {
        die('Failed to open email dir');
    }
}


?>