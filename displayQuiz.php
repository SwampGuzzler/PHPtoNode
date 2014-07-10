<?php 
	include('../useful_functions.php');
	$myQuiz = $_POST['pass-quiz'];
	$howmany = 0;	
	$display_name = $myQuiz;
	$myQuiz = replaceSpaces($myQuiz);
	
// ATTACH DATABASE named zoo_imagedb, returns PDO
	$database = $_COOKIE['cook_db'];
	$con = connecti_to_database($database);
//	$howmany = 3;
// now create an array of $howmany arrays w/ 4 cells each, load from quiz table
	$questionList = array();
	$rows = array();
	$myrow = array();
	for ($i = 0; $i < 10; $i++) {
		$rows[$i] = array();
	}
	for ($i = 1; $i < 11; $i++) {
		$result = mysqli_query($con, "SELECT image, lineColor, start_x, start_y, end_x, end_y, question
				FROM $myQuiz
				WHERE idQuestion = $i ");
		$myrow = mysqli_fetch_row($result);
		if ($myrow == FALSE) {
			$howmany = $i -1;
			break;
		}

// in cell 0 is image path
		if ($i == 1) {
			$short_path = $myrow[0];
			$lineColor = $myrow[1];
		}
		$j = $i-1;
		$rows[$j][0] = $myrow[2];
		$rows[$j][1] = $myrow[3];
		$rows[$j][2] = $myrow[4];
		$rows[$j][3] = $myrow[5];
		$questionList[$j] = $myrow[6];
		if ($i == 10) {
			$howmany = 10;
		}
	}
	mysqli_close($con);
	$animal_path = '../../iq_builder/' . $short_path;
//	echo 'howmany = '. $howmany . ' path is ' . $animal_path;
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>displayQuiz</title>
        <link rel="stylesheet" type="text/css" href="style_main.css"/>
		<script type="text/javascript" src="../handy_ask_functions.js"></script>	
	<script type="text/javascript">
	var cur_color = 'blue';

function captureColor(myColor) {
		cur_color = myColor;
		return;
	}

function bundleFunctions() {
	captureColor('<?php echo $lineColor; ?>');
	fillCanvasColor('myCanvas', 'white');
	var secretForm = document.getElementById("secret-info");	
	var quiz_image = secretForm.elements[0].value;	
	showImage('myCanvas', quiz_image);
	setTimeout(function() { putOnLabels('myCanvas', cur_color)}, 300);
	return;
}
// this call (below) works in Firefox
	window.onload = bundleFunctions;

</script>

    </head>
    <body >
	<div id="basicpage">
	<div id="return-spacer">
	</div>	
	
	<div id="return-div">
		<br /><form action="../index.php">
		<input type="submit" style="font-family: 'Georgia'; font-size: 1.1em; color: black; background-color: rgb(200,200,200); border: 4pt ridge lightgrey" value="Back to start" >
		</form> <br /><br />
		<br /><br /><br /><br /><br /><br />
	<span style="font-family: Times New Roman; font-weight: bold; font-size: 1.1em">Quiz: <br /> <?php echo $display_name; ?> </span>
		<br />		
	</div>
<!-------------------------------------------------------------------------->		
	<div id="image_div">
<canvas id="myCanvas" width="800" height="540" style="border:1px solid #c3c3c3;"> Your browser does not support the canvas element. </canvas><br />

	</div> <!-- end of image_div -->
<!-------------------------------------------------------------------------->		
	<div id="image_question_block">
		<form id="question_form" action="displayAnswers.php" method="post">
	<?php for ($i = 0; $i < $howmany; $i++) {
		$j = $i+1; ?>
		<?php $cur_label = 'Q '. $j. ': ' .$questionList[$i]; 
			$cur_name = 'user_answer_'. $i;
		?>
		<label><?php echo $cur_label; ?></label><br /> &nbsp &nbsp
		<input type="text" style="width:600px; height:20px" name="<?php echo $cur_name;?>" onkeypress="return event.keyCode!=13"/><br />
	<?php } ?>
		<input type="hidden" name="pass-quiz" action="displayAnswers.php" value="<?php echo $myQuiz; ?>"/>
		<input type="hidden" name="pass-howmany" value="<?php echo $howmany;?>" >
<!-- here's the submit button <br /> -->
	 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
	 </div> <!-- end questionblock -->
	 <div id="button-bit">
	 &nbsp &nbsp 
	<input type="submit" value="Submit" style="font-family: 'Georgia'; font-size: 1.1em; font-weight: bold; color: blue"/>
	</div> <!-- end button-bit -->
	</form>
	
<!-------------------------------------------------------------------------->	
	</div><!-- end image_answer div -->
	<!-- hidden form for label endpoint data -->
	<form id="secret-info" action="" method="post">
		<input type="hidden"  value="<?php echo $animal_path; ?>" size="90" /><br />
	</form>
	<form id="originForm" action="" method="post">
	<?php
		for ($i = 0; $i < $howmany; $i++) {
			for ($j = 0; $j < 4; $j++) { ?>
				<input type="hidden" value="<?php echo $rows[$i][$j]; ?>"/> 
		<?php } ?> <br />
	<?php	} ?>
	</form>
    </body>
</html>