<?php
	include('../useful_functions.php'); //Murach file loading function plus others

	$questionList = array();
	$answerList = array();
	$A_array = array();
	$howmany = $_POST['pass-howmany'];
	for ($count = 0; $count < $howmany; $count++) {
		$A_form_name = 'user_answer_'. $count;
		$A_array[$count] = $_POST[$A_form_name];
	}
	$myQuiz = $_POST['pass-quiz']; // quiz name 
	$display_name = $myQuiz;
	$display_name = replaceUnderscores($display_name);	
	
	$database = $_COOKIE['cook_db'];
	$con = connecti_to_database($database);

// now create an array of $howmany arrays w/ 4 cells each, load from quiz table
	$rows = array();
	$myrow = array();
	for ($i = 0; $i < 10; $i++) {
		$rows[$i] = array();
	}
	for ($i = 1; $i < 11; $i++) {
		$result = mysqli_query($con, "SELECT image, lineColor, start_x, start_y, end_x, end_y, question, answer_host
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
		$answerList[$j] = $myrow[7];
		if ($i == 10) {
			$howmany = 10;
		}		
	}
	mysqli_close($con);
	$animal_path = '../../iq_builder/' . $short_path;
	$box_height = array();
	for ($i = 0; $i < $howmany; $i++) {
		$n = strlen($answerList[$i]);
		$row_num = ceil($n/71);
		$box_height[$i] = $row_num;
	}		
 ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>display_answers</title>
        <link rel="stylesheet" type="text/css" href="style_main.css"/>
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
	setTimeout(function() {putOnLabels('myCanvas', cur_color)}, 200);
	return;
}
window.onload = function(){
   bundleFunctions();	
};	
</script>
	<script type="text/javascript" src="../handy_ask_functions.js"></script>
    </head>
    <body >
		<div id="image_answer">
	<div id="spacer">
	</div>
	<div id="where_to">

	<ul>
		<li><a href="selectQuiz.php"><span style="font-family: 'Georgia'; font-size: 1em">Go back to quiz list</span></a></li>
		<li><a href="selectCategory.php"><span>Choose another category</span></a></li>	
		<li><a href="../index.php"><span>Back to start page</span></a></li>	
	</ul><br /><br /><br /><br /><br /><br /><br /><br />
		<span style="font-family: Times New Roman; font-weight: bold; font-size: 1.1em">Quiz: <br /><?php echo $display_name; ?> &nbsp &nbsp &nbsp </span>
	</div> <!-- end where_to div -->
	
	<div id="image_div">	
<canvas id="myCanvas" width="800" height="540" style="border:1px solid #c3c3c3;">
Your browser does not support the canvas element.
</canvas>
	</div> <!-- end of image_div -->
	<div id="right_title">
	<p><strong>Quiz answers </strong></p>
	</div>	
	<div id="left_title">
	<p> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <strong>Your answers</strong> </p>
	</div>
		
	<div id="Q_and_A_block">
		<form id="box_form" method="post">
		<?php for ($i = 0; $i < $howmany; $i++) {
			$j = $i+1; 
			$H = $box_height[$i];
			$cur_label = 'Q '. $j. ': ' .$questionList[$i]; 
			$cur_name = 'user_answer_'. $i;
			?>
			<?php echo $cur_label; ?> <br /> <textarea  cols="71" rows="<?php echo $H; ?>"  ><?php echo $A_array[$i]; ?></textarea> 
			&nbsp &nbsp			
			<textarea  cols="71" rows="<?php echo $H; ?>"  ><?php echo $answerList[$i]; ?></textarea> <br />			
		<?php } ?>
		</form> 	
		
	</div> <!-- end questionblock -->			
<!-- hidden form for label endpoint data -->
	<form id="secret-info" action="" method="post">
		<input type="hidden"  value="<?php echo $animal_path; ?>" size="90" /><br />
	</form>
	<form id="originForm" action="" method="post">
	<?php
		for ($i = 0; $i < $howmany; $i++) {
			for ($j = 0; $j < 4; $j++) { ?>
				<input type="hidden" value="<?php echo $rows[$i][$j]; ?>"/>
		<?php } ?> 
	<?php	} ?>
	</form>				
		</div>
	</body>
</html>
				
