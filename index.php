<?php

?>	
<!DOCTYPE html>
<html lang="en-US">
   <head>
	<title>Ask index.php</title>

	<link href="Ipages/style_main.css" rel="stylesheet" type="text/css" />
	
<script type="text/javascript" src="handy_functions.js"></script>
<script type="text/javascript">
// global variable
	var myBrowser;
	
	function viewPopup() {
window.open( "IPopups/overview.php", "myWindow", 
"status = 1, width = 650, height = 900, left = 200, scrollbars=no, resizable = 0"  );
}
	function myPopup() {
window.open( "IPopups/wiringInstructions.php", "myWindow", 
"status = 1, width = 660, height = 900, left = 200, scrollbars=yes, resizable = 0"  );
}				
	function MRIPopup() {
window.open( "IPopups/MRI_notes.php", "myWindow", 
"status = 1, width = 660, height = 500, left = 200, scrollbars=yes, resizable = 0"  );
}				
function popup(mylink, windowname, size)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
   if (size == 'med') {
window.open(href, windowname, 'width=550,height=550,scrollbars=yes');
} else {
window.open(href, windowname, 'width=700,height=900,scrollbars=yes');
}
return false;
}

</script>

   </head>
  <body >
	<div id="basicpage">
	<div id="header-image">
		<p><img src="Ipages/Oregon_coast.jpg" class="home_image" alt="Oregon coast" /></p>
	</div>
  <div id="slogan">
	<h1>Interactive Quizzes</h1>
   </div>
   <div id="last_right">
   &nbsp 
   </div>
   
   
   
	<div id="right_home">
		<br /><span style="font-family: 'Georgia'; font-weight: bold; font-size: 1.3em">Information </span><br /><br />
		<input type="button" onClick="viewPopup()" style="font-family: 'Georgia'; font-weight: bold; font-size: 1.05em" 
		value="Overview of Interactive Quizzes"><br /><br />
		<input type="button" onClick="myPopup()" style="font-family: 'Georgia'; font-weight: bold; font-size: 1.05em" 
		value="Instructions for pathway quizzes"><br /><br />
		<input type="button" onClick="MRIPopup()" style="font-family: 'Georgia'; font-weight: bold; font-size: 1.05em" 
		value="Notes on MRIs"><br /><br />		
		
	</div> &nbsp &nbsp
   <div id="buffer_strip">
  &nbsp &nbsp
   </div>
   
   
   	<div id="task_div">	
	<!-- Next section lists tasks -->	
		<p><span style="font-family: 'Georgia'; font-weight: bold; font-size: 1.3em">  &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp Choose kind of quiz</span></p>
<!--	<form action="Ipages/selectCategory.php" method="post"> -->
	<form action="Ipages/selectCategory.php" method="post">
		<input type="hidden" name="what-kind" value="image"/>
		<input type="submit" value="Image-based quiz"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: red" />
	</form><br />
	<form action="Ipages/selectCategory.php" method="post">
		<input type="hidden" name="what-kind" value="wiring"/>
		<input type="submit" value="Pathway-drawing quiz"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: #7109aa" />
	</form><br />
	<form action="Ipages/selectCategory.php" method="post">
		<input type="hidden" name="what-kind" value="choice"/>
		<input type="submit" value="Choose quiz by brain section"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: #037c17" />
	</form><br />
	<form action="Story/selectionStrategy.php" method="post">
		<input type="hidden" name="what-kind" value="story"/>
		<input type="submit" value="Case studies"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: blue" />
	</form><br />
	<form action="Sets/selectSet.php" method="post">
		<input type="hidden" name="what-kind" value="set"/>
		<input type="submit" value="Build-a-Brain"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: black" />
	</form><br />
	<form action="MRIPages/selectStack.php" method="post">
		<input type="hidden" name="what-kind" value="mri"/>
		<input type="submit" value="MRIs"  style="font-family: 'Georgia'; font-weight: bold; font-size: 1.11em; color: #0343A9" />
	</form><br />	
	
	
	<br /><br />

		</div> <!-- end task_div -->

		<div id="space_div">
<!-- -->
		</div>
		<div id="copyright">
		Many of these quiz images are copyright-protected. Do not copy any image without written permission. (Contact H. Sherk at has@u.washington.edu)
		</div>
		</div><!-- end basicpage -->

   </body>
</html>