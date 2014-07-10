<?php
	include('../useful_functions.php'); 
	$temp = $_COOKIE['cook_cat'];
	if ($temp == 'none') {
		$my_cat = $_POST['pass-dir'];
		$my_cat = replaceSpaces($my_cat);
		setcookie('cook_cat', $my_cat, 0, '/');
	} else {
		$my_cat = $_COOKIE['cook_cat'];
	}
	$mydb = $_COOKIE['cook_kind'];	
	if ($mydb == 'image') {
		$destination = 'displayQuiz.php';
	}
	if ($mydb == 'wiring') {
		$destination = 'askForWiring.php';
	}
//	echo 'Got category '. $my_cat .'<br />';
// connect to database
	$database = $_COOKIE['cook_db'];
	$con = connecti_to_database($database);
// get category names from table categories, column contents
	$myrow = array();
	$quiz_list = array();
	for ($i = 0; $i < 50; $i++) {
		$j = $i+1;
		$result = mysqli_query($con, "SELECT $my_cat
				FROM categories
				WHERE idCategory = $j ");
		$myrow = mysqli_fetch_row($result);
		if ($myrow[0] == NULL) { // found an empty cell
			$howmany = $i;
			break;
		} else {
			$display_name = replaceUnderscores($myrow[0]);
			$quiz_list[$i] = $display_name;
		}
	}
	mysqli_close($con);	
	sort($quiz_list);
?>	
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>selectQuiz</title>
        <link rel="stylesheet" type="text/css" href="style_main.css"/>
	<script type="text/javascript">

	</script>	
    </head>
    <body >
	<div id="basicpage">
	<div id="header-image">
		<p><img src="Oregon_coast.jpg" class="home_image" alt="Oregon coast" /></p>
	</div>
  <div id="slogan">
	<h1>Interactive Quizzes</h1>
   </div>	
	<div id="right_block">
		<form action="../index.php">
		<input type="submit" style="font-family: 'Georgia'; font-size: 1.1em; color: black; background-color: rgb(200,200,200); border: 4pt ridge lightgrey" value="Back to start" >
		</form><br />
	</div>

	<div id="radio_div">
		<div id="radio_box">
		<p style="font-family: 'Georgia'; font-size: 1.2em; font-weight: bold"> &nbsp  &nbsp &nbsp &nbsp  &nbsp &nbsp Quizzes</p>
		<form id="list_form" action="<?php echo $destination; ?>" method="post">
		<?php foreach($quiz_list as $this_Q) : ?>
			<input type="radio" name="pass-quiz" value="<?php echo $this_Q;?>" /><?php echo $this_Q;?> 
			<br />
		<?php endforeach;?>	<br />	<br />
		</div><br />
		<input type="submit" style="font-family: 'Georgia'; font-size: 1.2em; font-weight: bold;  color: blue; " value = "Click to continue"/>	<!-- here's the submit button -->
		</form>
		&nbsp &nbsp

	</div> <!-- end radio_div -->		
	<div id="space_div">
		<form action="../index.php">
		<input type="submit" style="font-family: 'Georgia'; font-size: 1.1em; color: black; background-color: rgb(200,200,200); border: 4pt ridge lightgrey" value="Go back" >
		</form>			
	</div>	
	
	
	</div><!-- end basicpage -->
    </body>
</html>	