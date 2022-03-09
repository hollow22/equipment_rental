
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Profile Page</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<h1>IT Rental Portal</h1>
<h2>Profile page</h2>
<?php 

#User has successfully login
#use session
session_start();
unset($_SESSION['extend_cost']);
unset($_SESSION['end_date']);
#assign variables
$Role = $_SESSION['role'];
$Email = $_SESSION['email'];

#echo login details	
echo "<p>You are logged in as $Email</p>\n";
echo "Your role is $Role";



?>
</head>
<body>



<?php 


try{
	#initialize mysql connection
	$conn = @mysqli_connect("localhost", "root", "", "rental");
	$TableName = "available_rental";
    $items = array();
    $sql = "SELECT rentID, category, brand, description, regular_cost, extend_cost, status, start_date, end_date FROM $TableName WHERE rentUser = '$Email'";
    $qRes = @mysqli_query($conn, $sql);
	#if query returned more than 0 result
    if (mysqli_num_rows($qRes) > 0) {	
		#loop through the results with associate array
        while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
			#assign each line to items array 
            $items[] = $Row;
        mysqli_free_result($qRes);
    }
	
	$dates = array();
	$sql = "SELECT start_date, end_date FROM start_rent WHERE email = '$Email'";
	$query = @mysqli_query($conn, $sql);
	#if query returned more than 0 result
	if (mysqli_num_rows($query) > 0) {	
	#loop through the results with associate array
        while (($Row = mysqli_fetch_assoc($query))!= FALSE)
			#assign each line to dates array 
            $dates[] = $Row;
        mysqli_free_result($query);
    }
	#Close sql connection
    mysqli_close($conn);
}
catch (mysqli_sql_exception $e){
	#Catch error 
   die ("<p>Error in connection with the database server or database </p>\n");
}



?>

<?php
	#echo $dates[0]['start_date'];
	#var_dump($dates);
	if ($Role == 'admin') #If role is admin 
	{
		#display item listings and add item button
		echo "<form method='post' " . " action='item_listings.php?" . SID . "'>\n";
		echo "<br><input type='submit' name='submit' " . " value='View Listings'>\n";
		echo "</form>\n"; 
		
		
		echo "<form method='post' " . " action='additem.php?" . SID . "'>\n";
		echo "<br><input type='submit' name='submit' " . " value='Insert new listing'>\n";
		echo "</form>\n"; 
	}
	else #if role is not admin
	{ 
			
		#display item listing button, history button
		echo "<form method='post' " . " action='item_listings.php?" . SID . "'>";
		echo "<br> <input type='submit' name='submit' " . " value='View Listings'>";
		echo "</form>"; 
		#echo "<br>";
		
		echo "<form method='post' " . " action='history.php?" . SID . "'>";
		echo "<br> <input type='submit' name='submit' " . " value='View History'>";
		echo "</form>"; 
		echo "<br>";

		#if current rent is not empty, display the current renting table
		if (count($items) != 0){ 
			#Table headers
			echo "Your current rentals: ";
			echo "<table border='1' width='100%'>\n";
			echo "<tr>\n";
			echo " <th style='background-color:lightgrey'>Category</th>\n";
			echo " <th style='background-color:lightgrey'>Brand</th>\n";
			echo " <th style='background-color:lightgrey'>Description</th>\n";
			echo " <th style='background-color:lightgrey'>Regular cost</th>\n";
			echo " <th style='background-color:lightgrey'>Extend cost</th>\n";
			echo " <th style='background-color:lightgrey'>Status</th>\n";
			echo "</tr>\n";
			
			#for each loop to display each items in the items array
			?>
			
			<?php
			foreach ($items as $item) {		
				echo "<tr>\n";
				echo " <td>" . htmlentities($item['category']) . "</td>\n";
				echo " <td>" . htmlentities($item['brand']) . "</td>\n";
				echo " <td>" . htmlentities($item['description']) . "</td>\n";
				
				echo " <td>" . htmlentities($item['regular_cost']) . "</td>\n";
				echo " <td>" . htmlentities($item['extend_cost']) . "</td>\n";
				
				if ($item['status'] == 'Unavailable'){
					#Display start date and end date 
					
					echo " <td> Renting ";
					#echo $item['rentID'];
					echo "start date: ";
					echo htmlentities($item['start_date']) ;
					echo " to ";
					echo htmlentities($item['end_date']) ;
					#echo $dates[$c]['start_date'];
					#echo "- ";
					#echo $dates[$c]['end_date'];
					
					?>
					<form action ='request_extend.php?' method='get'>
					<input type ="hidden" value="<?php echo $item['start_date']; ?>" name="start_date">
					<input type ="hidden" value="<?php echo $item['end_date']; ?>"name="end_date">
					<input type ="hidden" value="<?php echo $item['rentID']; ?>" name='rentID'>
					<input type ="hidden" value="<?php echo $item['extend_cost']; ?>" name='extend'>
					<input type ="submit" value = "Extend" class='open-button'> 
					</form>
					<?php
					
					#function to return item php 
					echo "<a href='return.php?" . SID . "&rentID=" . $item['rentID'] . "'> 
					<input type ='button' value='Return' style = 'color:green'> </input> </a></td> ";
					
					#echo "<input type ='submit' value='extend'> </td>\n";
					
					#function to extend rent item 

					
				}
					
			}
			?>
			
			<?php
		}
	}
?>

<?php 
#logout button
echo "<table border='0' width='100%'>\n";
#echo "<tr>";
#echo "<td>";
include ("logout.php"); 
#echo "</td>";
#echo "</tr>";
echo "</table>";
?>






</html>
