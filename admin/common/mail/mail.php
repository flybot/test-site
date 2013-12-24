<?php

require_once 'class.phpmailer.php';

 /**
 * Validate Email Addresses Via SMTP
 * This queries the SMTP server to see if the email address is accepted.
 * @copyright http://creativecommons.org/licenses/by/2.0/ - Please keep this comment intact
 * @author gabe@fijiwebdesign.com
 * @contributers adnan@barakatdesigns.net
 * @version 0.1a
 */
class SMTP_validateEmail {

 //PHP Socket resource to remote MTA
 //@var resource $sock
 var $sock;

 //Current User being validated
 var $user;
 //Current domain where user is being validated
 var $domain;
 //List of domains to validate users on
 var $domains;
 //SMTP Port
 var $port = 25;
 // Maximum Connection Time to an MTA // seconds per host
 var $max_conn_time = 2;
 //Maximum time to read from socket
 var $max_read_time = 2;

 //username of sender
 var $from_user = 'user';
 //Host Name of sender
 var $from_domain = 'localhost';

 //Nameservers to use when make DNS query for MX entries
 //@var Array $nameservers
 var $nameservers = array(
 '192.168.0.1'
);

 var $debug = false;

 /**
  * Initializes the Class
  * @return SMTP_validateEmail Instance
  * @param $email Array[optional] List of Emails to Validate
  * @param $sender String[optional] Email of validator
  */
 function SMTP_validateEmail($emails = false, $sender = false) {
	if ($emails) {
		$this->setEmails($emails);
	}
	if ($sender) {
		$this->setSenderEmail($sender);
	}
 }

 function _parseEmail($email) {
	$parts = explode('@', $email);
	$domain = array_pop($parts);
	$user= implode('@', $parts);
	return array($user, $domain);
 }

 /**
  * Set the Emails to validate
  * @param $emails Array List of Emails
  */
 function setEmails($emails) {
	foreach($emails as $email) {
		list($user, $domain) = $this->_parseEmail($email);
		if (!isset($this->domains[$domain])) {
			$this->domains[$domain] = array();
		}
		$this->domains[$domain][] = $user;
	}
 }

 /**
  * Set the Email of the sender/validator
  * @param $email String
  */
 function setSenderEmail($email) {
	 $parts = $this->_parseEmail($email);
	 $this->from_user = $parts[0];
	 $this->from_domain = $parts[1];
 }

 /**
 * Validate Email Addresses
 * @param String $emails Emails to validate (recipient emails)
 * @param String $sender Sender's Email
 * @return Array Associative List of Emails and their validation results
 */
 function validate($emails = false, $sender = false) {
     $results = array();

     if ($emails) {
        $this->setEmails($emails);
     }
     if ($sender) {
        $this->setSenderEmail($sender);
     }

     // query the MTAs on each Domain
     foreach($this->domains as $domain=>$users) {

        $mxs = array();

        // retrieve SMTP Server via MX query on domain
        list($hosts, $mxweights) = $this->queryMX($domain);

        // retrieve MX priorities
        for($n=0; $n < count($hosts); $n++){
            $mxs[$hosts[$n]] = $mxweights[$n];
        }
        asort($mxs);

        // last fallback is the original domain
        array_push($mxs, $this->domain);

        $this->debug(print_r($mxs, 1));

        $timeout = $this->max_conn_time;//count($hosts);

        // try each host
        $errno  = -1;
        $errstr = '';
        while(list($host) = each($mxs)) {
            // connect to SMTP server
            $this->debug("try $host:$this->port\n");
            if ($this->sock = fsockopen($host, $this->port, $errno, $errstr, (float) $timeout)) {
                $this->debug("ERROR: $errno [$errstr]");
                stream_set_timeout($this->sock, $this->max_read_time);
                break;
            }
        }

        // did we get a TCP socket
        if ($this->sock) {
            $reply = fread($this->sock, 2082);
            $this->debug("<<<\n$reply");

            preg_match('/^([0-9]{3}) /ims', $reply, $matches);
            $code = isset($matches[1]) ? $matches[1] : '';

            if($code != '220') {
            // MTA gave an error...
                foreach($users as $user) {
                    $results[$user.'@'.$domain] = false;
                }
                continue;
            }

            // say helo
            $this->send("HELO ".$this->from_domain);
            // tell of sender
            $this->send("MAIL FROM: <".$this->from_user.'@'.$this->from_domain.">");

            // ask for each recepient on this domain
            foreach($users as $user) {
                // ask of recepient
                $reply = $this->send("RCPT TO: <".$user.'@'.$domain.">");

                // get code and msg from response
                preg_match('/^([0-9]{3}) /ims', $reply, $matches);
                $code = isset($matches[1]) ? $matches[1] : '';

                if ($code == '250') {
                    // you received 250 so the email address was accepted
                    $results[$user.'@'.$domain] = true;
                } elseif ($code == '451' || $code == '452') {
                    // you received 451 so the email address was greylisted (or some temporary error occured on the MTA) - so assume is ok
                    $results[$user.'@'.$domain] = true;
                } else {
                    $results[$user.'@'.$domain] = false;
                }

            }

            // quit
            $this->send("quit");
            // close socket
            fclose($this->sock);

        }
        else{ //if($this->sock)//
			$this->debug('socket not opened');
			/* //uncoment this if you want send mail on not exists domain
            $this->debug("ELSE ERROR: $errno [$errstr]");
            foreach($users as $user) {
                    $results[$user.'@'.$domain] = true;
                }//*/
        }
  }
 return $results;
 }


 function send($msg) {
     fwrite($this->sock, $msg."\r\n");

     $reply = fread($this->sock, 2082);

     $this->debug(">>>\n$msg\n");
     $this->debug("<<<\n$reply");

     return $reply;
 }

 /**
  * Query DNS server for MX entries
  * @return
  */
 function queryMX($domain) {
     $hosts = array();
     $mxweights = array();
     if (function_exists('getmxrr')) {
        getmxrr($domain, $hosts, $mxweights);
     } else {
         // windows, we need Net_DNS
         require_once 'Net/DNS.php';

         $resolver = new Net_DNS_Resolver();
         $resolver->debug = $this->debug;
         // nameservers to query
         $resolver->nameservers = $this->nameservers;
         $resp = $resolver->query($domain, 'MX');
         if ($resp) {
            foreach($resp->answer as $answer) {
                $hosts[] = $answer->exchange;
                $mxweights[] = $answer->preference;
            }
         }

     }
     return array($hosts, $mxweights);
 }

 /**
  * Simple function to replicate PHP 5 behaviour. http://php.net/microtime
  */
 function microtime_float() {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
 }

 function debug($str) {
  if ($this->debug) {
   echo htmlentities($str) . "<br />";
  }
 }

}
?>
<?php
/**
 * Validate Email Addresses
 * @param Array $emails Emails to validate
 * @param String $sender Sender's Email
 * @return Array Associative List of Emails and their validation results
 */
function validate($emails, $sender){
	$result = Array();
	foreach($emails as $email){
		$smtpval = new SMTP_validateEmail();
		@$res = $smtpval->validate(Array($email), $sender);
		$result = array_merge($result, $res);
	}
	return $result;
}

/**
 * Prepare data and send email
 * @param Array $to Emails of receivers (recipients)
 * @param String $subject Email Subject (in utf-8)
 * @param String $text Email HTML body (in utf-8)
 * @param Array  $copy Emails to send copy (CC)
 * @param Array  $bcc Emails to send hidden copy (CC)
 * @return Array
 */
function sendmail($sender, $sendername, $to, $subject, $text, $copy = false, $bcc = false, $inreply=false, $gmail_username=false, $gmail_password=false){

    if (!$gmail_username || !$gmail_password){
        try {
            global $gmail_user;
            global $gmail_pass;
            $gmail_username = $gmail_user;
            $gmail_password = $gmail_pass;

        } catch (Exception $exc) {
            return Array('status'     => false,									//return status 'true'
                         'count'      => 0,
                         'duplicates' => array(),
                         'bad'        => array(),
                         'to'         => array(),
                         'copy'       => array(),
                         'bcc'        => array(),
                        );
        }
    }

    $smail = new PHPMailer();
    $smail->Encoding = 'base64';
    $smail->CharSet  = 'utf-8';
    $smail->IsSMTP();
    $smail->SMTPAuth   = true;                  // enable SMTP authentication
    $smail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $smail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $smail->Port       = 465;                   // set the SMTP port

    $smail->Username   = $gmail_username;       // GMAIL username
    $smail->Password   = $gmail_password;       // GMAIL password

    //check recipients
    $bad  = Array();

	//check mails format
	foreach($to as $ind=>$email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
			$bad[] = $email;
			unset($to[$ind]);
		}
	}
	if ($copy) {
	foreach($copy as $ind=>$email){
		if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
			$bad[] = $email;
			unset($copy[$ind]);
		}
	}
	}
	if ($bcc) {
	foreach($bcc as $ind=>$email){
		if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
			$bad[] = $email;
			unset($bcc[$ind]);
		}
	}
	}
	//
	//check repeat
	$duplicates = Array();
	$to   = array_unique($to);
	if ($copy) $copy = array_unique($copy);
	if ($bcc) $bcc  = array_unique($bcc);
	foreach($to as $mail){
		if ($copy) {
		foreach($copy as $k=>$v)	//kill eq in 'to' and 'copy'
			if ($v == $mail) {
				$duplicates[] = $v;
				unset($copy[$k]);
			}
        }
        if ($bcc) {
		foreach($bcc as $k=>$v)		//kill eq in 'to' and 'bcc'
			if ($v == $mail){
				$duplicates[] = $v;
				unset($bcc[$k]);
			}
        }
	}
	if ($copy AND $bcc) {
	foreach($copy as $mail)
		foreach($bcc as $k=>$v)		//kill eq in 'copy' and 'bcc'
			if ($v == $mail){
				$duplicates[] = $v;
				unset($bcc[$k]);
			}}
	$duplicates = join(', ', $duplicates); //make csv

	//Check user exists
        /*
        $res = validate($to, $sender); //get validated mails
        $to = Array();					// clear array
        foreach($res as $addr=>$stat){
            if (!$stat) $bad[] = $addr;	//bad email
            else $to[] = $addr;			//good email. place in recipients array
        }
        //check copy
        if ( $copy ){
            $res = validate($copy, $sender);
            $copy = Array();
            foreach($res as $addr=>$stat){
                if (!$stat) $bad[] = $addr;
                else $copy[] = $addr;
            }
        }
        //check hidden copy
        if ( $bcc ){
            $res = validate($bcc, $sender);
            $bcc = Array();
            foreach($res as $addr=>$stat){
                if (!$stat) $bad[] = $addr;
                else $bcc[] = $addr;
            }
        }//*/

    $count = count($to) + count($copy) + count($bcc); 	//mails count
    $bad = join(', ', $bad);							//make csv from bad array

    //$subject = '=?utf-8?b?'. base64_encode($subject) .'?='; //subject in base64

    //$text = $text; //no transform yet

    if ( !$to ){ //We dont have recioients!
        return Array('status'     => false,
                     'count'      => 0,
                     'duplicates' => $duplicates,
                     'bad'        => $bad,
                     'to'         => $to,
                     'copy'       => $copy,
                     'bcc'        => $bcc,
                    ); //return status 'false'
    }
    
    // ===================

    if ($inreply){
        if ($inreply === true) $smail->AddCustomHeader("In-Reply-To: $subject");
        else $smail->AddCustomHeader("In-Reply-To: $inreply");
    }
    $mid = '<' . md5((string)time()) . "@" . $_SERVER['HTTP_HOST'] . '>';
    $smail->MessageID  = $mid;
    $smail->From       = $sender;
    $smail->FromName   = $sendername;
    $smail->Subject    = $subject;
    $smail->AltBody    = "This is the body when user views in plain text format"; //Text Body
    $smail->WordWrap   = 50; // set word wrap

    $smail->MsgHTML($text);

    foreach($to as $mto)
        $smail->AddAddress($mto);
    foreach($copy as $mcc)
        $smail->AddCC($mcc);
    foreach($bcc as $mbcc)
        $smail->AddBCC($mbcc);

    $smail->IsHTML(true); // send as HTML

    if ($_SERVER['HTTP_HOST'] != '112.localhost' /*&& 0 > 1*/){
        if(!$smail->Send()) {
          echo "Mailer Error: " . $smail->ErrorInfo;
          return Array('status'     => false,
                         'count'      => 0,
                         'duplicates' => $duplicates,
                         'bad'        => $bad,
                         'to'         => $to,
                         'copy'       => $copy,
                         'bcc'        => $bcc,
                        ); //return status 'false'
        }
    }
    
    // ===================

    /*
    $mto  = join(", ", $to);							//Create csv for recipients
    $mcc  = $copy ? "CC: "  . join("\r\nCC: " , $copy) . "\r\n" : '';           //Create header for CC
    $mbcc = $bcc  ? "BCC: " . join("\r\nBCC: ", $bcc)  . "\r\n" : '';           //Create header for BCC

    $header  = "Content-type: text/html; charset=\"utf-8\"\r\n";		//type and charset
    $header .= "From: ". $sendername ." <". $sender ."> \r\n";			//name and email of sender
    $header .= "MIME-Version: 1.0\r\n";						//standart
    $header .= "Date: ". date('D, d M Y H:i:s O') ."\r\n";			//current time
    $header .= $mcc;								//append CC and BCC
    $header .= $mbcc;

    mail($mto, $subject, $text, $header);					//send email
    */

    return Array('status'     => true,						//return status 'true'
                 'count'      => $count,
                 'duplicates' => $duplicates,
                 'bad'        => $bad,
                 'to'         => $to,
                 'copy'       => $copy,
                 'bcc'        => $bcc,
                 'message_id' => $mid,
                );
}//sendmail()
?>