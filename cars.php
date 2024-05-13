<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
	<?php
    include "header.php";
    ?>
    <h3>Search your cars option by reference, brand, or year</h3>
    <form class="example" action=""  method="post">
		<?php
			//include information required to access database
			require 'authentication.php'; 

			//start a session 
			session_start();

			//still logged in?
			if (!isset($_SESSION['db_is_logged_in'])
				|| $_SESSION['db_is_logged_in'] != true) {
				//not logged in, move to login page
				header('Location: login.php');
				exit;
			} else {
				//logged in 
				// Connect database server

				$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

				// check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				echo "<br>Connected successfully<br>";

				// Prepare SQL query (Year selection)
				$query = "SELECT DISTINCT(Year) FROM CAR";

				// Execute SQL query
				$result = $conn->query($query)
				or die( "ERROR: Query is wrong");

				echo "<input type=\"text\" name=\"reference\" placeholder=\"Search by reference \">";
				echo "<input type=\"text\" name=\"brand\" placeholder=\"Search by brand \">";
				echo "<select name=\"year\">";
				echo "<option value=\"all\">All</option>";
					// fetch table records
					while( $row = $result->fetch_assoc() ) {
						// Year from CAR table
						$name = $row['Year'];
						echo "<option value=\"$name\"> $name </option>";
					}
				echo "</select>";
				echo "<button type=\"submit\"><i class=\"fa fa-search\" value=\"Search\"></i></button>";           
			}
		?>
	</form>

    <form action="" method="post">
		<?php
			//logged in 
			// Connect database server
			// prepare SQL query (Showing the table)

			// prepare SQL query (Showing the table)
			$query = "SELECT Reference, Brand, Year, RentFee
					FROM CAR, RENT
					WHERE CAR.ReferenceID = RENT.ReferenceID";

			
			if (isset($_POST['year'])) {
				if (!empty($_POST["year"])) {
					$year = $_POST["year"];
					if ($year == "All") {
						$query .= " AND CAR.Year = \"$year\"";
					}
				}
				if (!empty($_POST["reference"])) {
					$reference = $_POST["reference"];
					$query .= " AND CAR.Reference LIKE \"$reference%\"";
				}
				
				if (!empty($_POST["brand"])) {
					$brand = $_POST["brand"];
					$query .= " AND CAR.Brand LIKE \"$brand%\"";
				}
			} 

			// print the query
			//echo "Query: ".$query."<br>";
	
			// Execute SQL query
			$result = $conn->query($query)
				or die( "ERROR: Query is wrong");

			if (!$result) {
				echo "Error message: " . $conn->error;
			}

			// Check if there are any results
			if ($result->num_rows > 0) {
				// Print the number of results returned
				echo $result->num_rows . " results found according to your search.<br>";
			
				// Display results in a table
				echo "<table border=1>";
				echo "<tr>";
				echo "<th>#</th>";
				// fetch attribute names
				$fieldinfo=$result->fetch_fields();
				foreach ($fieldinfo as $fieldMetadata) {
					echo "<th>".$fieldMetadata->name."</th>";
				}
				echo "<th>Action</th>";
				echo "</tr>";
				
				// Reset result pointer to first row
				mysqli_data_seek($result, 0);


				// fetch rows in the table
				$i=1;
				while( $row = $result->fetch_assoc() ) {
					echo "<tr>\n";
					echo "<td>".$i."</td>";
					foreach ($row as $cell) {
						echo "<td> $cell </td>";
					}
					echo "<td><form method='POST' action='description.php'>
								<button type='submit' name='description' value='".$row['Reference']."'>Description</button>
							</form></td>";
					echo "</tr>\n";
					$i++;
				}
				echo "</table>";
			} else {
				echo "0 results found. Showing all cars. <br>";
			
				$query = "SELECT Reference, Brand, Year, RentFee FROM CAR, RENT WHERE CAR.ReferenceID = RENT.ReferenceID";
			
				// Execute SQL query
				$result = $conn->query($query) or die("ERROR: Query is wrong");
			
				if (!$result) {
					echo "Error message: " . $conn->error;
				}
			
				// Display results in a table
				echo "<table border=1>";
				echo "<tr>";
				echo "<th>#</th>";
				// fetch attribute names
				$fieldinfo=$result->fetch_fields();
				foreach ($fieldinfo as $fieldMetadata) {
					echo "<th>".$fieldMetadata->name."</th>";
				}
				echo "<th>Action</th>";
				echo "</tr>";

				// Reset result pointer to first row
				mysqli_data_seek($result, 0);
			
				// fetch rows in the table
				$i=1;
				while( $row = $result->fetch_assoc() ) {
					echo "<tr>\n";
					echo "<td>".$i."</td>";
					foreach ($row as $cell) {
						echo "<td> $cell </td>";
					}
					echo "<td><form method='POST' action='description.php'>
								<button type='submit' name='description' value='".$row['Reference']."'>Description</button>
							</form></td>";
					echo "</tr>\n";
					$i++;
				}
				echo "</table>";
			}
			
			// close the connection with database
			$conn->close();
		?>
	</form>            
	<?php
    include "footer.php";
    ?>		
</body>
</html>