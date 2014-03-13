<?php
  $number = $_POST['number'];
  if (isset($number)) {
	 $count = intval($_COOKIE['count']);
	 setcookie('number'.$count,$number);
	 $count++;
  } else {
	foreach ($_COOKIE as $key => $value )
	  setcookie($key, FALSE);
	$count = 0;
  }
  setcookie('count', $count);
?>
<html>
	<head>
		<title>My Lottery</title>
	</head>
	<body>
	   <h2>My Lottery</h2>
	   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	   <?php
	      if ($count == 0) {
		    echo "<h3>Wellcome!!</h3>";
	      } else {
		    echo "<label>Your winning numbers are: </label>";
		    for ($i = 0; $i < $count-1; $i++)
				echo "<b>".$_COOKIE['number'.$i]."</b>, ";
			echo "<b>$number</b></p>";
		  }
		  if ($count == 6) {
			  echo "<h3>Good luck!!</h3>";
		  } else { 
	    ?>
	   <label>Please, enter a number:</label>
	   <input type='text' name='number'/>
	   <input type='submit'>
	   <?php } ?>
	   </form>
	</body>
</html>