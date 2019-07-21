<!DOCTYPE html>
<html lang="en"> 
<head>
<title>Guest Book</title>
<head>

<body>
<h1>Guest Book</h1>

<?php

$GuestArray = array();

if (isset($_GET['action']))
{
	if ((file_exists("GuestBook/guests.txt")) && (filesize("GuestBook/guests.txt") != 0))
	{
		$GuestArray = file("GuestBook/guests.txt");
		switch ($_GET['action']) 
		{
			case 'Remove Duplicates':
				$GuestArray = array_unique($GuestArray);
				$GuestArray = array_values($GuestArray);
				break;
			case 'Sort':
				sort($GuestArray);
				break;
		} // End of the switch statement
	}
	
	//if (isset($GuestArray) && count($GuestArray)>0)
	if (count($GuestArray)>0)
	{
		$NewGuests = implode($GuestArray);

		$GuestsStore = fopen("GuestBook/guests.txt", "wb");
		if ($GuestsStore === false)
		{
			echo "There was an error updating the guests file\n";
		}
			else 
		{
			fwrite($GuestsStore, $NewGuests);
			fclose($GuestsStore);
		}
	}
	else
		unlink("GuestBook/guests.txt");

}
	
if (isset($_POST['submit']))
{
	if ($_POST['VisitorName'] == "")
	{
		echo "<p>The guest name cannot be empty<br />\n";
	}
	else
	{
		$GuestsToAdd = stripslashes($_POST['VisitorName'])." ".stripslashes($_POST['Email']) . "\n";
		$ExistingGuests = array();

		if (file_exists("GuestBook/guests.txt") && filesize("GuestBook/guests.txt") > 0)
		{
		$ExistingGuests = file("GuestBook/guests.txt");
		}

		if (in_array($GuestsToAdd, $ExistingGuests)) 
		{
			echo "<p>The guest you entered already exists!<br />\n";
			echo "Your guest was not added to the list.</p>";
		}
		else
		{
			$GuestFile = fopen("GuestBook/guests.txt", "ab");
	
			if ($GuestFile === false)
			{
				echo "There was an error saving your message!\n";
			}
			else 
			{
				fwrite($GuestFile, $GuestsToAdd);
				fclose($GuestFile);
				echo "Your guest has been added to the list.\n";
			}
		}
	}
}

clearstatcache();
if ((!file_exists("GuestBook/guests.txt")) || (filesize("GuestBook/guests.txt") == 0))
	echo "<p>There are no guest entries in the list.</p>\n";
else 
{
	$GuestArray = file("GuestBook/guests.txt");
	echo "<table border=\"1\" width=\"100%\"style=\"background-color:lightgray\">\n";
	
	foreach ($GuestArray as $Guest)
	{
		echo "<tr>\n";
		echo "<td>" . htmlentities($Guest)."</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
}

?>

<p>
<a href="index.php?action=Sort">Sort Guest Book by Name</a><br />
<a href="index.php?action=Remove%20Duplicates">Delete Duplicate Guests</a><br />
</p>

<form action="index.php" method="post">

<p>Guest Book Entries</p>
<p>Visitor Name: <input type="text" name="VisitorName"/></p>
<p>Email:        <input type="text" name="Email"/></p>

<p>
<input type="submit" name="submit" value="Add Name and Email" />
<input type="reset" name="reset" value="Reset Name and Email" />
</p>

</form>

</body>

</html>