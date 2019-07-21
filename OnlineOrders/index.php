<!DOCTYPE html>
<html lang="en"> 
<head>
<title>Online Orders</title>
<head>

<body>
<h1>Online Orders</h1>

<?php

	$Name = array(
		"Optical Mouse",
		"Mobile Mouse",
		"Wireless Mouse",
		"Wireless Keyboard and Mouse",
		"Mouse Pad"
	);
	
	$Description = array(
		"Microsoft Wireless Mobile Mouse 1850 Coal Black",
		"ADNS2620 - Optical Mouse Sensor IC",
		"Logitech M171 Wireless Mouse Black",		
		"Logitech MK235 Wireless Keyboard and Mouse Combo Black",
		"H+O Mouse Pad with Wrist Support"
	);
	
	$Price = array(
		25.95,
		18.99,
		24.99,
		49.99,
		14.99	
	);
	

if (isset($_POST['submit'])) 
{
	$Quantity = stripslashes($_POST['Quantity']);
	$Unitprice = stripslashes($_POST['Unitprice']);
	$ItemName = stripslashes($_POST['ItemName']);
	$Desc = stripslashes($_POST['Desc']);
	
	echo "<p>The Total Price is $ ".(int)$Quantity*(float)$Unitprice."</p>\n";
	
	$OrderDetails = $ItemName.", ".$Desc.", ".$Unitprice.", ".$Quantity.", ".((int)$Quantity*(float)$Unitprice);

	$fnam = date("YdmHis");
	$filename = fopen("OnlineOrders/"."$fnam".".txt", "wb");
	fwrite($filename, $OrderDetails);
	fclose($filename);
}
?>

<form action="index.php" method="post">
	<p>
	Item name:
	<select id="ItemName" name="ItemName">
	<?php	
	foreach ($Name as $key => $val)
	{
		echo "<option value='$val'";
		if (isset($_POST['submit']) && strcmp($ItemName,$val)==0)
			echo " selected";
		echo ">$val</option>\n";

	}?>
	</select>

	</p>

	<p>
	Item Description:
	<select name="Desc">
	<?php
	foreach ($Description as $key => $val)
	{
		echo "<option value='$val'";
		if (isset($_POST['submit']) && strcmp($Desc,$val)==0)
			echo " selected";
		echo ">$val</option>\n";
	}
	?>
	</select>
	</p>

	<p>
	Item Price:
	<select name="Unitprice">
	<?php
	foreach ($Price as $key => $val)
	{
		echo "<option value='$val'";
		if (isset($_POST['submit']) && strcmp($Unitprice,$val)==0)
			echo " selected";
		echo ">$val</option>\n";
	}
	?>
	</select>
	</p>
	
	<p>
	Quantity: <input type="text" name="Quantity" value="<?php if (isset($_POST['submit'])) echo $_POST['Quantity'];?>"/></p>
	</p>
	
	<p><input type="submit" name="submit" value="Calculate Total Price" /></p>
</form>

</body>

</html>