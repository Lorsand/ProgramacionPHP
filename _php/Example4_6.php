<?php
$path = "data.txt";
if (file_exists($path))
  $file = fopen($path, "r+");
else
  $file = fopen($path, "a+");
while ($data = fread($file,154)) {
  $array[] = explode('|',$data);
};

if (isset($_GET['get'])) {
  $curr = (int)$_GET['get'];
  $item = $array[$curr];
} else if (isset($_GET['delete'])) {
  $curr = (int)$_GET['delete'];
  fseek($file,$curr*154,SEEK_SET);
  fwrite($file,'**deleted**');
  $array[$curr][0] = '**deleted**';
  $item = array('','','','','');
  $curr = 0;
} else if (isset($_GET['save'])) {
	$curr = (int)$_GET['save'];
	$item = array(str_pad($_GET['name'],30),
	              str_pad($_GET['work'],30),
				  str_pad($_GET['mobile'],30),
				  str_pad($_GET['email'],30),
				  str_pad($_GET['address'],30));
	fseek($file,$curr*154,SEEK_SET);
	fwrite($file,implode('|',$item));
	$array[$curr] = $item;
} else if (isset($_GET['append'])) {
  $item = array('','','','','');
  $curr = sizeof($array);
};

fclose($file);
?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<head>
		<title>Contacts</title>
	</head>
	<body>
	 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	  <div style="width: 250px; float: left;">
	  	<h3>All Contacts</h3>
		<table width="150" border=1>
		  <?php
			for ($i=0;$i<sizeof($array);$i++) {
			  if (trim($array[$i][0])!="**deleted**")
			    echo '<tr><td><a href="?get='.$i.
				     '" style="text-decoration:none;">'.
				     $array[$i][0].'</a></td></tr>';
		    }
		  ?>
		</table>
	    </p>
		<button name="append" value="">+</button>
	  </div>
	  <div style="margin-left:250px;">
		  <table>
			<tr><td>&nbsp;</td></tr>
			<tr><td><label>name</label></td><td>
				<input name="name" size="30" value="<?php echo $item[0]; ?>"/></td></tr>
			<tr><td><label>work</label></td><td>
				<input name="work" size="30" value="<?php echo $item[1]; ?>"/></td></tr>
			<tr><td><label>mobile</label></td><td>
				<input name="mobile" size="30" value="<?php echo $item[2]; ?>"/></td></tr>
			<tr><td><label>email</label></td><td>
				<input name="email" size="30" value="<?php echo $item[3]; ?>"/></td></tr>
			<tr><td><label>address</label></td><td>
				<input name="address" size="30" value="<?php echo $item[4]; ?>"/></td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td><button name="delete" value="<?php echo $curr; ?>">-</button></td>
				<td align="right">
				<button name="save" value="<?php echo $curr; ?>">Save</button></td></tr>
		  </table>
	    </div>
	  </form>
	</body>
</html>