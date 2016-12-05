<!DOCTYPE html>
<html>
<h1>Location Numeral Converter</h1>
<body>

<?php
function getLetter($twopower=0){
$letters = str_split('abcdefghijklmnopqrstuvwxyz');
return $letters[$twopower];
}
function getPower($letter){
$letters = str_split('abcdefghijklmnopqrstuvwxyz');
$number = 0;
foreach ($letters as $l){
	if($letter == $l){
		break;
	}
	$number+= 1;
}
return $number;
}
function simplify($LN){
	$arrayLN = str_split($LN);
	$simpLN = "";
	$dictLN = array("a"=>0);
	foreach($arrayLN as $key){
		$dictLN[$key] = 0;
	}
	foreach($arrayLN as $j){
		$dictLN[$j] += 1;
	}
	ksort($dictLN);
	foreach($dictLN as $key => $val){
		if($val == 0){
			unset($dictLN[$key]);
		}
		else{
			if(isset($dictLN[getLetter(getPower($key)+1)])){
				$dictLN[getLetter(getPower($key)+1)] += floor($dictLN[$key]/2);
			}else{
				$dictLN[getLetter(getPower($key)+1)] = floor($dictLN[$key]/2);
			}
			$dictLN[$key] %= 2;
		}
	}
	ksort($dictLN);
	foreach($dictLN as $key => $val){
		if ($val >0){
			for($x = 0; $x<$val; $x++){
				$simpLN = $simpLN.$key;
			}
		}
	}
return $simpLN;
}

function convertToLN($number) {
/*This function converts a number to its location numeral. 
It takes number given by the user.
*/
$LN = "";
$twopower = 0;
while($number > 0){
	if($number >= (2**$twopower)){
		$LN = $LN . getLetter($twopower);
		$number -= (2**$twopower);
		$twopower += 1;
	}else{
		$twopower -= 1;
	}
}
return simplify($LN);
}
function convertToNumber($LN){
$locArray = str_split($LN);
$number = 0;
foreach($locArray as $l){
		$number += (2**getPower($l));
	}
return $number;
}
if (!empty($_POST["number"] > 0)){
	echo $_POST["number"]." converts to ".convertToLN($_POST["number"])."<br />";
}
if (!empty($_POST["LNumeral"])){
	echo $_POST["LNumeral"]." converts to ".convertToNumber($_POST["LNumeral"])."<br />";
}
if(!empty($_POST["LNtbA"])){
	echo $_POST["LNtbA"]." abbreviates to ".simplify($_POST["LNtbA"])."<br />";
}
?>

</body>
</html>