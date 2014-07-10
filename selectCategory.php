<?php 
	setcookie('cook_cat', 'none', 0, '/');
	$temp = $_COOKIE['cook_cat'];
	include('../useful_functions.php');
	if (isset($_POST['what-kind'])) {
		$mydb = $_POST['what-kind'];

//		echo 'Got cook_cat = ' .$temp . ' $mydb '. $mydb . '<br/>';		
		if ($mydb == 'image') {
//			echo 'Using image pathway...<br />';
			setcookie('cook_db', 'neuro_imagedb', 0, '/');
			setcookie('cook_kind', 'image', 0, '/');
			$destination = 'selectQuiz.php';
			$database = 'neuro_imagedb';
		}
		if ($mydb == 'wiring') {
//			echo 'Using wiring pathway...<br />';		
			setcookie('cook_db', 'neuro_wiringdb', 0, '/');			
			setcookie('cook_kind', 'wiring', 0, '/');		
			$destination = 'selectQuiz.php';
			$database = 'neuro_wiringdb';
		}
		if ($mydb == 'choice') {	
			setcookie('cook_db', 'neuro_choicedb', 0, '/');			
			setcookie('cook_kind', 'choice', 0, '/');		
			setcookie('cook_dot_count', 0, 0, '/');			
			setcookie('cook_quiz_name', 'none', 0, '/');		
			setcookie('cook_choice_image', 'none', 0, '/');					
			$destination = 'chooseSection.php';	
			$database = 'neuro_choicedb';
		}	
	}
	else {
		$database = $_COOKIE['cook_db'];
		$mydb = $_COOKIE['cook_kind'];
		if ($mydb == 'image' || $mydb == 'wiring') {		
			$destination = 'selectQuiz.php';
		}
		if ($mydb == 'choice') {		
			$destination = 'chooseSection.php';	
		}
	}
// connect to database
//	echo 'got $database '. $database . '<br />';
	$con = connecti_to_database($database);

// get category names from table categories, column contents
	$myrow = array();
	$contents_list = array();
	for ($i = 0; $i < 50; $i++) {
		$j = $i+1;
		$result = mysqli_query($con, "SELECT contents
				FROM categories
				WHERE idCategory = $j ");
		$myrow = mysqli_fetch_row($result);
		if ($myrow[0] == NULL) { // found an empty cell
			$howmany = $i;
			break;
		} else {
			$contents_list[$i] = $myrow[0];
		}
	}
	mysqli_close($con);
	sort($contents_list);
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>selectCategory</title>
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
	</div>
	<div id="radio_div">
		<div id="radio_box">
		<p style="font-family: 'Georgia'; font-size: 1.2em; font-weight: bold"> &nbsp  &nbsp &nbsp Quiz Categories</p>
		<form id="list_form" action="<?php echo $destination;?>" method="post">
		<?php foreach($contents_list as $this_dir) : 
			$this_dir = replaceUnderscores($this_dir);?>
			<input type="radio" name="pass-dir" value="<?php echo $this_dir;?>" /><?php echo $this_dir;?> 
			<br />
		<?php endforeach;?>	<br />	
		<input type="submit" style="font-family: 'Georgia'; font-size: 1.2em; font-weight: bold;  color: blue" value = "Click to continue"/>	<!-- here's the submit button -->
		</form><br /><br />
		</div>
		<br /><form action="../index.php">
			<input type="submit" style="font-family: 'Georgia'; font-size: 1.1em; color: black; background-color: rgb(200,200,200); border: 4pt ridge lightgrey" value="Go back" >
			</form>
		</div> <!-- end radio_div -->	
	<div id="space_div">
	</div>		
	</div><!-- end basicpage -->
    </body>
</html>	