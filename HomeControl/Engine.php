<?php

namespace HomeControl;

class Engine {

    public function __construct($commandString) {
        if (strlen($commandString) > 0) {
            foreach($this->parseCommand($commandString) as $device => $status) {
                $cachedDevice = \HomeControl\Cache::getInstance()->fetch($device);
                if (is_object($cachedDevice)) {
                    //TODO: add logic per device, should be editable

			if ($device == "Sensor-overloop-1e") {
				$lightDevice = \HomeControl\Cache::getInstance()->fetch('Overloop-1e-verdieping-niveau');
				$luxDevice = \HomeControl\Cache::getInstance()->fetch('Sensor-overloop-1e-lux');
				switch(strtolower($status)) {
					case "on":
						if (intval($luxDevice->getStatus()) < 25) {
							$lightDevice->switchLevel(2);
						}
						break;
					case "off":
						$lightDevice->switchOff();
						break;
				}
			}

			if ($device == "Zolder-motion-sensor") {
				$lightDevice = \HomeControl\Cache::getInstance()->fetch('Overloop-zolder-niveau');
				$luxDevice = \HomeControl\Cache::getInstance()->fetch('Zolder-lux');
				switch(strtolower($status)) {
					case "on":
						if (intval($luxDevice->getStatus()) < 25) {
							$lightDevice->switchLevel(2);
						}
						break;
					case "off":
						$lightDevice->switchOff();
						break;
				}
			}

			if ($device == "doorbell") {
				$lightDevice = \Homecontrol\Cache::getInstance()->fetch('hal-beganegrond-niveau');
				$luxDevice = \HomeControl\Cache::getInstance()->fetch('hal-beganegrond-lux');

				$username = '';
				$password = '';

				switch(strtolower($status)) {
					case "on":
						if (intval($luxDevice->getStatus()) < 40) {
							$lightDevice->switchLevel(30);
						}
						$ch = curl_init(); 
						curl_setopt($ch, CURLOPT_URL, "http://USERNAME:PASSWORD@CAMERAIP/cgi-bin/ptz.cgi?action=start&channel=1&code=GotoPreset&arg1=0&arg2=2&arg3=0");
						curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
						curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
						$output = curl_exec($ch); 

						sleep(2);

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://CAMERAIP/cgi-bin/snapshot.cgi");
						curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
						curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
						$picture = curl_exec($ch);
						curl_close($ch);

						// fetch image
						$fh = fopen('/tmp/deurbel.jpg', 'wa+');
						fwrite($fh, $picture);
						fclose($fh);

						$this->mailAttachment('roland@andriese.eu', 'deurbel ' . date('H:i:s'), 'er is zojuist aangebeld, zie bijlage', 'thuis@andriese.eu', '/tmp/deurbel.jpg', 'deurbel.jpg', 'image/jpeg');
						$this->mailAttachment('deniseninaber@gmail.com', 'deurbel ' . date('H:i:s'), 'er is zojuist aangebeld, zie bijlage', 'thuis@andriese.eu', '/tmp/deurbel.jpg', 'deurbel.jpg', 'image/jpeg');
						break;
					case "off":
						$lightDevice->switchOff();
						$ch = curl_init(); 
						curl_setopt($ch, CURLOPT_URL, "http://USERNAME:PASSWORD@CAMERAIP/cgi-bin/ptz.cgi?action=start&channel=1&code=GotoPreset&arg1=0&arg2=1&arg3=0");
						curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
						curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
						$output = curl_exec($ch); 
						break;
				}
			}

                    //after logic has been processed, update device
                    $cacheUpdate = \HomeControl\Domoticz::getInstance()->updateDevice($cachedDevice->getIdx());
                    if ($cacheUpdate) {
			mail('roland@andriese.eu', 'docache', 'true');
                        \HomeControl\Cache::getInstance()->store($cachedDevice->getName(), $cachedDevice);
                    }
                }
            }
        }
    }

    public function parseCommand($commandString) {
        $deviceAndStatusPairs = array();
        foreach(explode('#', $commandString) as $deviceAndStatusPair) {
            $keyval=explode('|',$deviceAndStatusPair);
            if(count($keyval) > 1) {
                $deviceAndStatusPairs[$keyval[0]] = $keyval[1];
            } else {
                //$deviceAndStatusPairs[$keyval[0]] = '';
            }
        }
        return $deviceAndStatusPairs;
    }

    public function mailAttachment($to, $subject, $body, $from, $photoPath, $photoName, $filetype)
    {
        $bound_text = md5(uniqid(rand(), true));;
        $bound = "--" . $bound_text . "\r\n";
        $bound_last = "--" . $bound_text . "--\r\n";

        $headers = "From:" . $from . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

        $message =      "Sorry, your client doesn't support MIME types.\r\n"
        . $bound;

        $message .=     "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $body . "\r\n";
        //. $bound;

        $file = file_get_contents($photoPath);
	    if (!empty($file)) {

		    $message .= $bound;
	        $message .=     "Content-Type: $filetype; name=\"$photoName\"\r\n"
	        . "Content-Transfer-Encoding: base64\r\n"
	        . "Content-disposition: attachment; file=\"$photoName\"\r\n"
	        . "\r\n"
	        . chunk_split(base64_encode($file))
	        . $bound_last;
	    } else {
    		$message .= $bound_last;
	    	$message = str_replace(', zie bijlage', ', bijlage mislukt', $message);
	    }

        if(mail($to, $subject, $message, $headers))
        {
             echo 'MAIL SENT!' . '<br>';
             echo 'to: ' . $to . '<br>';
             echo 'from: ' . $from . '<br>';
             echo 'bodyText: ' . $body . '<br>';
             echo 'photoPath: ' . $photoPath . '<br>';
             echo 'photoName: ' . $photoName . '<br>';
             echo 'filetype: ' . $filetype . '<br>';
        }
        else
        {
             echo 'MAIL FAILED';
        }
    }


}
