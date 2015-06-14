<?php

function isoDateToMsSql($dateString) {
	$format = "Y-m-d H:i:s P";
	if (strlen($dateString) > 18)
	{
		// $dateString = substr($dateString, 0, 19);
		// $dateString = str_replace("T", " ", $dateString);
		if (DateTime::createFromFormat($format, $dateString))
		{
			$date = DateTime::createFromFormat($format, $dateString);
			return $date->format($format);
		}
	}
	if (strlen($dateString) == 10)
	{
		$date = DateTime::createFromFormat("Y-m-d", $dateString);
		return $date->format($format) . " 00:00 +00:00";
	}
	return "1970-01-01 00:00 +00:00";
}


/*
$date = date('c');
print_r($date);


$dateString = date('c');
echo '<h3>';

echo $dateString;
//2015-02-10 00:00:00.000 +06:00

//2004-02-12T15:19:21+06:00
echo '</h3>';

$format = "Y-m-d H:i:s P";
echo $format . '<br>';

*/
$dateString2 = '2015-02-10 00:00:00.000 +06:00';
echo $dateString2;
echo '<br>';

$dateString = date('Y-m-d H:i:s P');
echo $dateString;
echo '<br>';


//$date = DateTime::createFromFormat($format, $dateString);
if (DateTime::createFromFormat('c', $dateString2)) {
$dateString2 = '2015-02-10 00:00:00.000 +06:00';
echo $dateString2;
echo '<br>';

}

echo '<br>';
//$date->format($format);

//print_r($date->format($format));


//print_r(isoDateToMsSql('2004-02-12T15:19:21+06:00'));

