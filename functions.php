<?php
include 'fields.php';


// Priortize Degrees according to answers given
function priortizeDegrees($sevcs,$csvit,$sevit)
{
	$error=FALSE;$SE=0;$CS=0;$IT=0;
	if ($sevcs=='se') {
		$SE++;
	} else if ($sevcs=='cs') {
		$CS++;
	} else {
		$error=true;
	}

	if ($csvit=='cs') {
		$CS++;
	} else if ($csvit=='it') {
		$IT++;
	} else {
		$error=true;
	}

	if ($sevit=='se') {
		$SE++;
	} else if ($sevit=='it') {
		$IT++;
	} else {
		$error=true;
	}

	if ($SE==$CS&&$CS==$IT&&$IT==$SE) {
		$error=true;
	}


	if ($error) {
		return FALSE;
	}
	else{
		$data = array();
		$data[$SE] = 'se';
		$data[$CS] = 'cs';
		$data[$IT] = 'it';
		krsort($data);
		$data=array_values($data);
		return $data;
	}
}

// Priortize degree timing and campus according to answers given
function priortizeMajor($degvcamp,$degvtime,$campvtime)
{
	$error=FALSE;$deg=0;$time=0;$camp=0;
	if ($degvcamp=='deg') {
		$deg++;
	} else if ($degvcamp=='camp') {
		$camp++;
	} else {
		$error=true;
	}



	if ($degvtime=='deg') {
		$deg++;
	} else if ($degvtime=='time') {
		$time++;
	} else {
		$error=true;
	}


	if ($campvtime=='camp') {
		$camp++;
	} else if ($campvtime=='time') {
		$time++;
	} else {
		$error=true;
	}

	if ($deg==$camp&&$camp==$time&&$time==$deg) {
		$error=true;
	}


	if ($error) {
		return FALSE;
	}
	else{
		$data = array();
		$data[$deg] = 'deg';
		$data[$camp] = 'camp';
		$data[$time] = 'time';
		krsort($data);
		$data=array_values($data);
		return $data;
	}
}

//Priortize fields according to the users answers
function priortizeOverall($priMaj,$priDeg,$timing,$campus,$fields)
{
	$tempFields=$fields;
	if ($priMaj[2]=='camp') {
		$tempFields=rearrangeAsCampus($tempFields,$campus);
		if ($priMaj[1]=='time') {
			$tempFields=rearrangeAsTiming($tempFields,$timing);
			$tempFields=rearrangeAsDegree($tempFields,$priDeg);
		}
		else {
			$tempFields=rearrangeAsDegree($tempFields,$priDeg);
			$tempFields=rearrangeAsTiming($tempFields,$timing);
		}
	}
	else if ($priMaj[2]=='time') {
		$tempFields=rearrangeAsTiming($tempFields,$timing);
		if ($priMaj[1]=='camp') {
			$tempFields=rearrangeAsCampus($tempFields,$campus);
			$tempFields=rearrangeAsDegree($tempFields,$priDeg);
		}
		else {
			$tempFields=rearrangeAsCampus($tempFields,$campus);
			$tempFields=rearrangeAsDegree($tempFields,$priDeg);
		}
	}
	else if ($priMaj[2]=='deg') {
		$tempFields=rearrangeAsDegree($tempFields,$priDeg);
		if ($priMaj[1]=='camp') {
			$tempFields=rearrangeAsCampus($tempFields,$campus);
			$tempFields=rearrangeAsTiming($tempFields,$timing);
		}
		else {
			$tempFields=rearrangeAsTiming($tempFields,$timing);
			$tempFields=rearrangeAsCampus($tempFields,$campus);
		}
	}
	else{
		return FALSE;
	}
	return $tempFields;
}

//rearrange fields according to campus priorities
function rearrangeAsCampus($tempFields,$camp)
{
	$tempFinal;
	if ($camp=='old') {
		foreach ($tempFields as $key => $value) {
			if(substr($key, 2,1)=='o'){
				$tempFinal[$key]=$value;
			}
		}
		foreach ($tempFields as $key => $value) {
			if(substr($key, 2,1)=='n'){
				$tempFinal[$key]=$value;
			}
		}
	}
	else if ($camp=='new') {
		foreach ($tempFields as $key => $value) {
			if(substr($key, 2,1)=='n'){
				$tempFinal[$key]=$value;
			}
		}
		foreach ($tempFields as $key => $value) {
			if(substr($key, 2,1)=='o'){
				$tempFinal[$key]=$value;
			}
		}
	}
	else{
		return FALSE;
	}
	return $tempFinal;
}

//rearrange fields according to timing priorities
function rearrangeAsTiming($tempFields,$time)
{
	$tempFinal;
	if ($time=='mor') {
		foreach ($tempFields as $key => $value) {
			if(substr($key, 3,1)=='m'){
				$tempFinal[$key]=$value;
			}
		}
		foreach ($tempFields as $key => $value) {
			if(substr($key, 3,1)=='a'){
				$tempFinal[$key]=$value;
			}
		}
	}
	else if ($time=='aft') {
		foreach ($tempFields as $key => $value) {
			if(substr($key, 3,1)=='a'){
				$tempFinal[$key]=$value;
			}
		}
		foreach ($tempFields as $key => $value) {
			if(substr($key, 3,1)=='m'){
				$tempFinal[$key]=$value;
			}
		}
	}
	else{
		return FALSE;
	}
	return $tempFinal;
}

//rearrange fields according to degree's priorities
function rearrangeAsDegree($tempFields,$priDeg){
	$tempFinal;
	if ($priDeg[0]=='se') {
		if ($priDeg[1]=='cs') {
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
		}
		else{
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
		}
	}
	else if ($priDeg[0]=='cs') {
		if ($priDeg[1]=='it') {
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
		}
		else{
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
		}
	}
	else if ($priDeg[0]=='it') {
		if ($priDeg[1]=='se') {
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
		}
		else{
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='it'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='cs'){
					$tempFinal[$key]=$value;
				}
			}
			foreach ($tempFields as $key => $value) {
				if(substr($key, 0,2)=='se'){
					$tempFinal[$key]=$value;
				}
			}
		}
	}
	else{
		return FALSE;
	}
	return $tempFinal;
}

?>
