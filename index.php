<?php $ph = $_SERVER["HTTP_REFERER"];
$url = isset($ph) ? $ph : "http://usa.splashabout.com/";
$redirect = str_replace("usa.splashabout.com","www.splashabout.com",$url);

// this checks the referring URL and will (later on) check to see if the same URL exists on the new location
// you'll need to update the URL for line 118 - process.php

// fun Javascript follows

?>


function updateCookie(name,initValue,days){
    if (readCookie(name)!==null){
        var value = readCookie(name);
        createCookie(name,value,days);
    }
    else {
        createCookie(name,initValue,days);
    }
}


var country = "";

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
  }
  
  
 var ccph = readCookie('_country');
  



<?php

if (!isset($_COOKIE['_country'])) {

// get the IP address 
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}




		$o = "";
        $lookup = "http://www.geoplugin.net/json.gp?ip=" . $ip;
		
		$result = @file_get_contents($lookup);
		$country = json_decode($result);
		
		if ($result != "")
			{
				$o = $country->geoplugin_countryCode;
				
				if ($o == "GB")
				{
					echo "var country = \"UK\";";
	
				}
			}
	}
	else {
	
	$temp = filter_var($_COOKIE['_country'],FILTER_SANITIZE_STRING);
	
	echo "var country = ".$temp;
	
	}
	
			
				
				?>
				
				

				
window.onload = function() {
    if (window.jQuery) {  
        // jQuery is loaded  
	jQuery(document).ready(function() {
	
	if (ccph===null && country == "UK")
	{
		
		 jQuery.ajax({
		type: "POST",
		url: "process.php",
		data: "URL=<?= $redirect; ?>",
		cache: false,
		success: function(data) {
			
			jQuery('a.wbmdBootOvlyBtn').attr('href',JSON.parse(data).redirect);
			}
		});
		
		jQuery('#maincontent').append('<div id="colorbox"><div id="webmdHoverWrapper"><div id="webmdHoverContent"><div id="webmdHoverLoadedContent"><div id="overlay" class="wbmdBootOvly lrg"><div class="wbmdBootOvlyCont"><div class="wbmdBootSection uk"><p>You appear to be in the UK. Go to UK site:</p><span class="flagBtn"><a href="<?php echo $redirect; ?>" class="wbmdBootOvlyBtn">www.splashabout.com</a><i class="wbmdBootOvlyFlag"></i></span></div><div class="wbmdBootSection us"><p>Stay on US site:</p><span class="flagBtn"><a href="#" class="wbmdBootOvlyBtn2">stay</a><i class="wbmdBootOvlyFlag"></i></span></div></div></div></div></div></div></div></div>');
	
	    jQuery('a.wbmdBootOvlyBtn2').click(function() {
			
			jQuery('#colorbox').remove();
			updateCookie("_country", country, 2);
		});
		
		jQuery('a.wbmdBootOvlyBtn').click(function() {
			
			updateCookie("_country", country, 2);
		});
			
	
	
	}
		
	
	
});
    } else {
	console.log('failed to load');
	}
}				
				
				

				

				
				
