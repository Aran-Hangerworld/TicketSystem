<?php

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function SendSTMP(){
$msg = wordwrap($msg,70);
mail($to,$sub,$msg);
}

function reverse_date($mydate){
	$date_created = explode("-", $mydate);
	$date_reversed = array_reverse($date_created);
	$i = 0; 
	foreach($date_reversed as &$value) {
		echo $value;
		if($i == 0 || $i == 1){
			echo "-";	
		}
		$i++;
	}
}

function parse_priority($input){	
	 switch ($input){
		case 1:
			$ptytxt = "Low";
			$ptyicon = "";
			$ptycolor = "Info";
			break;
		case 2:
			$ptytxt = "Medium";
			$ptyicon = "";
			$ptycolor = "Info";
			break;			
		case 3: 
			$ptytxt = "High";
			$ptyicon = "exclamation-sign";
			$ptycolor = "Warning";
			
			break;
		case 4:
			$ptytxt= "Urgent";
			$ptyicon = "warning-sign";
			$ptycolor = "Danger";
			break;
		case 5:
			$ptytxt = "Arghh!!";
			$ptyicon = "warning-sign";
			$ptycolor = "Warning";
			break;
	}
	return array($ptytxt, $ptyicon, $ptycolor);
}

function parse_status($status_input){
	switch($status_input){
		case 1:
			$statustxt = "Pending";
			$statusclr = "info";
			break;
		case 2:
			$statustxt = "Open";
			$statusclr = "warning";
			break;
		case 3:
			$statustxt = "Resolved";
			$statusclr = "success";
			break;
		case 4:
			$statustxt = "Cancelled";
			$statusclr = "danger";
			break;
		case 5:
			$statustxt = "On Hold";
			$statusclr = "danger";
			break;	
	}	
		return array($statustxt, $statusclr);
}

?>