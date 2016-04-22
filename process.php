<?php 
header('Access-Control-Allow-Origin: http://magento2.pushonltd.co.uk');
// update this....

$redirect="http://www.splashabout.com/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $redirect = test_input($_POST["URL"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  return $data;
}


function get_headers_curl($url) 
{ 
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL,            $url); 
    curl_setopt($ch, CURLOPT_HEADER,         true); 
    curl_setopt($ch, CURLOPT_NOBODY,         true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    curl_setopt($ch, CURLOPT_TIMEOUT,        5); 

    $r = curl_exec($ch); 
    $r = explode("\n", $r); 
    return $r; 
} 


$response = get_headers_curl($redirect);
$r = trim($response[0]);
	if($r != 'HTTP/1.1 200 OK' && (strpos($r, 'HTTP/1.1 30') === false))
	{
		$parseURL = explode("/",$redirect);
		//$onedown[];
		for ($i=2;$i<(count($parseURL)-1);$i++)
		{
			$onedown[] = $parseURL[$i];
		}
		$rph = implode("/",$onedown);
		$redirect = $parseURL[0]."//".$rph;
		
		$response = get_headers_curl($redirect);
		$r = trim($response[0]);
		if($r != 'HTTP/1.1 200 OK' && (strpos($r, 'HTTP/1.1 30') === false))
		{
			$redirect = $parseURL[0]."//".$parseURL[2];
		}
	}
	
	$ph['redirect']=$redirect;

	echo json_encode($ph);
	
	?>
