
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>History rentals</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<h1>IT Rental Portal</h1>
<h2>History rents</h2>
<?php 

#User has successfully login
#use session
session_start();
unset($_SESSION['extend_cost']);
unset($_SESSION['end_date']);
#assign variables
$Role = $_SESSION['role'];
$Email = $_SESSION['email'];


#echo "<br> <button class ='back'> Return to <a href='profilepage.php'> profile page </a> </button>"; 

?>
</head>
<body>



<?php 


try{
	#initialize mysql connection
	$conn = @mysqli_connect("localhost", "root", "", "rental");
	
	#History table
	$TableName = "rent_history";
    $items = array();
    $sql = "SELECT * FROM $TableName WHERE rentUser = '$Email'";
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
	
		#display item listing button, history button
		echo "<form method='post' " . " action='item_listings.php?" . SID . "'>\n";
		echo "<br> <input type='submit' name='submit' " . " value='View Listings'>\n";
		echo "</form>\n"; 
		echo "<br>";
		
		echo "<form method='post' " . " action='profilepage.php?" . SID . "'>\n";
		echo "<br> <input type='submit' name='submit' " . " value='Profile page'>\n";
		echo "</form>\n"; 
		echo "<br>";

		
		#Display history rental details
		if (count($items) != 0){ 
			#Table headers
			echo "Your history rentals: ";
			echo "<table border='1' width='100%'>\n";
			echo "<tr>\n";
			echo " <th style='background-color:lightgrey'>Category</th>\n";
			echo " <th style='background-color:lightgrey'>Brand</th>\n";
			#echo " <th style='background-color:lightgrey'>Description</th>\n";
			echo " <th style='background-color:lightgrey'>Start date</th>\n";
			echo " <th style='background-color:lightgrey'>End date</th>\n";
			#echo " <th style='background-color:lightgrey'>Status</th>\n";
			echo "</tr>\n";
			
			#for each loop to display each items in the items array
			foreach ($items as $item) {		
				echo "<tr>\n";
				echo " <td>" . htmlentities($item['category']) . "</td>\n";
				echo " <td>" . htmlentities($item['brand']) . "</td>\n";
				#echo " <td>" . htmlentities($item['description']) . "</td>\n";
				
				echo " <td>" . htmlentities($item['start_date']) . "</td>\n";
				echo " <td>" . htmlentities($item['end_date']) . "</td>\n";

			}
		}
	
?>



<?php
#logout button
include ("logout.php"); 
?>




</html>
