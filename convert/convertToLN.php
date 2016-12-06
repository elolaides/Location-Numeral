<!DOCTYPE html>
<html>
<h1>Location Numeral Converter</h1>
<body>

<?php
function getLetter($twopower=0){
/*This function takes the power of two (2^n, n is the power), generates 
an array from the alphabet i.e. $letters = ('a','b','c'...,'x','y','z') 
and returns the letter at the nth entry. i.e. $letters[4] = 'e'
*/
$letters = str_split('abcdefghijklmnopqrstuvwxyz');
return $letters[$twopower];
}
function getPower($letter){
/* This function take a letter in the alphabet
finds its entry in an alphabet array and returns a number
that is the letters place value in the alphabet array
*/
	$letters = str_split('abcdefghijklmnopqrstuvwxyz');/*creates alphabet array*/
	$number = 0;					/*counter to find the place of the letter in question*/
	foreach ($letters as $l){		/*check each letter in order as the var $l*/
		if($letter == $l){			/*check if that letter $l is the letter in question*/
			break;					/*if it is break free*/
		}
		$number+= 1;				/*increment count if $l is not the letter in question*
								so the letter in question is c the counter starts at 0 
								checks if the letter is a it is not so the counter becomes 1
								checks if the letter is b it is not so the counter becomes 2
								checks if the letter is c it is so it breaks out of the loop*/
}

return $number;
}
function simplify($LN){
	/*This function takes a Location Numeral (a string) 
	makes an array out of its letters
	makes a dictionary entry for each letter in a dictionary
	looks at every entry in the dictionary and adjusts values
	adds letters to a string according to values in dictionary*/
	
	$arrayLN = str_split($LN); 		//make array of letters in Location Numeral(LN)
	$simpLN = ""; 					//initialize simplified location Numeral string
	$dictLN = array("a"=>0);		//initialize dictionary
	foreach($arrayLN as $key){		//goes through each letter in the LN
		$dictLN[$key] = 0;			//creates dict entry
	}
	foreach($arrayLN as $j){		//goes through each letter in LN
		$dictLN[$j] += 1;			//increments value in dictionary
	}
	ksort($dictLN);					//puts the dictionary in abc order
	foreach($dictLN as $key => $val){												//goes through each entry of the dictionary
		if($val == 0){																//checks if the value at that entry is 0
			unset($dictLN[$key]);													//if so, that entry is removed from the dictionary
		}
		else if ($key != 'z'){														//if the value at the entry is not 0 it checks if the entry is 'z'
																					//z is the last letter in the alphabet and the highest 'number' possible in LN
			if(isset($dictLN[getLetter(getPower($key)+1)])){						//checks if the next letter in the alphabet is an entry in the dictionary
							//getPower(a)=0 -> 0+1 = 1->getLetter(1)='b'->$dictLN['b']
				$dictLN[getLetter(getPower($key)+1)] += floor($dictLN[$key]/2);		//if the next letter exists add the value the letter integer divided by 2 to the next letter
																					//'a' value is 3, 3 int divided by 2 = 1, add ont to 'b' value
			}else{
				$dictLN[getLetter(getPower($key)+1)] = floor($dictLN[$key]/2);		//this does the same thing but sets the entry up 
			}
			$dictLN[$key] %= 2;														//set the letter value to itself mod 2
							//dictLN['a'] = 3 -> 3 mod 2 = 1 -> dictLN['a'] = 1
		}
	}
	ksort($dictLN);							//put dictionary back in order after all that 
	foreach($dictLN as $key => $val){		//interate over the dictionary entries
		if ($val >0){						//check if the letter value is greater than 0 i.e. letter occurs more that 0 times
			for($x = 0; $x<$val; $x++){		//for that amount of times it occurs append it to the new, simplified LN
				$simpLN = $simpLN.$key;
			}
		}
	}
return $simpLN;
}

function convertToLN($number) {
/*This function takes a number
converts number to Location Numeral
*/
	$LN = "";
	$twopower = 0;

/*This while loop:
	if the number isn't 0
	check if the number is greater than or equal to the current power of two indicated by twopower
	if it is append the letter corresponding to that power (2^3 -> 3 -> 3 corresponds to d) to the LN
	check if the power is less than 25 (25 corresponds with z and nothing can be greater than z)
	or
	if the number isn't greater than or equal to the power of 2 go down a power
	
*/
	while($number > 0){
		if($number >= (2**$twopower)){
			$LN = $LN . getLetter($twopower);
			$number -= (2**$twopower);
			if($twopower < 25){
				$twopower += 1;
		}
		}else{
			$twopower -= 1;
		}
}
return simplify($LN);
}
function convertToNumber($LN){
/* this function takes a Location Numeral (string)
makes an array from the LN
for each letter in the array sums the corresponding power of 2 into a total */

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