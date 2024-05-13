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
                echo "Connected successfully<br>";

                // prepare SQL query
                // fix the query
                $uid = $_SESSION['userID'];
                $table="QUOTE";
                $sql = "SELECT Date, QuoteID, Reference, Brand, RentFee
                                FROM $table, CAR, RENT, CUSTOMER
                                WHERE QUOTE.RentID = RENT.RentID
                                AND CUSTOMER.CustomerID = QUOTE.CustomerID
                                AND RENT.ReferenceID = CAR.ReferenceID
                                AND CUSTOMER.userid = '$uid'
                                ORDER BY Date DESC";

                if (empty($_POST["cancel"])) {
                    echo "<b>All orders that you have made:</b><br><br>";
                    // Execute query
                    $result = $conn->query($sql);
                    if (!$result) {
                        echo "Query is wrong: $sql";
                        die;
                    }

                    // Output query results: HTML table
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

                        // fetch rows in the table
                        $i=1;
                        while( $row = $result->fetch_assoc() ) {
                            echo "<tr>\n";
                            echo "<td>".$i."</td>";
                            foreach ($row as $cell) {
                                echo "<td> $cell </td>";
                            }
                            echo "<td><form method='POST' action=''>
                                            <button type='submit' name='cancel' value='".$row['QuoteID']."'>Cancel</button> 
                                        </form></td>";
                            echo "</tr>\n";
                            echo "</tr>\n";
                            $i++;
                        }
                    echo "</table>";
                } else {
                    // Insert data into table
                    $quoteID=$_POST["cancel"];
                    $table="QUOTE";
                    $sql="DELETE
                                FROM $table
                                WHERE QuoteID = $quoteID;";
                    
                    // Execute the query
                    $result = $conn->query($sql)
                        or die( "SQL Query ERROR. Data cannot be inserted.");

                    echo "<span style=\"color:red;\">Your order with QuoteID $quoteID was canceled successfully.</span><br><br>";
                    echo "<b>All orders that you have made:</b><br><br>";

                    // Prepare query
                    $table="QUOTE";
                    $sql = "SELECT Date, QuoteID, Reference, Brand, RentFee
                                FROM $table, CAR, RENT, CUSTOMER
                                WHERE QUOTE.RentID = RENT.RentID
                                AND CUSTOMER.CustomerID = QUOTE.CustomerID
                                AND RENT.ReferenceID = CAR.ReferenceID
                                AND CUSTOMER.userid = '$uid'
                                ORDER BY Date DESC";

                    // Execute query
                    $result = $conn->query($sql);
                    if (!$result) {
                        echo "Query is wrong: $sql";
                        die;
                    }

                    // Output query results: HTML table
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

                        // fetch rows in the table
                        $i=1;
                        while( $row = $result->fetch_assoc() ) {
                            echo "<tr>\n";
                            echo "<td>".$i."</td>";
                            foreach ($row as $cell) {
                                echo "<td> $cell </td>";
                            }
                            echo "<td><form method='POST' action=''>
                                            <button type='submit' name='cancel' value='".$row['QuoteID']."'>Cancel</button> 
                                        </form></td>";
                            echo "</tr>\n";
                            echo "</tr>\n";
                            $i++;
                        }
                    echo "</table>";
                } 
            }         	
    ?>
    <?php
    include "footer.php";
    ?>
</body>