<?php
header('Content-Type: application/json');
if (isset($_GET['sevcs'])&&isset($_GET['csvit'])&&isset($_GET['sevit'])&&isset($_GET['newvold'])&&isset($_GET['morvaft'])&&isset($_GET['degvcamp'])&&isset($_GET['degvtime'])&&isset($_GET['campvtime'])) {
	//if all parameters are given.

	//include files
	include 'fields.php';
	include 'functions.php';

	//Priortize se, cs ,it as 1,2,3
	$priDeg=priortizeDegrees($_GET['sevcs'],$_GET['csvit'],$_GET['sevit']);
	//Priortize degree,campus,timing as 1,2,3
	$priMaj=priortizeMajor($_GET['degvcamp'],$_GET['degvtime'],$_GET['campvtime']);

	$campus=$_GET['newvold'];
	$timing=$_GET['morvaft'];

	//to store data initialize string
	$resultToAppend="\n";

	//degrees are appended to string in order of higher preferences
	foreach ($priDeg as $key => $value) {
		$resultToAppend.=$value.";";
	}

	//campus and timing are appended to string
	$resultToAppend=$resultToAppend.$campus.";".$timing.";";

	//degree,campus,timings are appended to string in order of higher preferences
	foreach ($priMaj as $key => $value) {
		$resultToAppend.=$value.";";
	}

	//time appended to string
	$resultToAppend.=time().";";
	//write result string to result file
	//it is used for analytics
	$handle = fopen('results.txt', 'a');
	fwrite($handle, $resultToAppend);

	//prioritise all data
	$priorities=priortizeOverall($priMaj,$priDeg,$timing,$campus,$fields);
	$priorities=array_values($priorities);

	//return result in the form of JSON
	echo json_encode($priorities);
}
else {
	$error=['error'=>'1','msg'=>'Invalid parameters passed!'];
	echo json_encode($error);
}
?>
