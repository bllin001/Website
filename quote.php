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

                // Get Customer ID
                $uid = $_SESSION['userID'];
                $table = "CUSTOMER";
                $sql = "SELECT * FROM $table where userid = '$uid'";

                // Execute SQL query
                $result = $conn->query($sql)
                or die( "ERROR: Query is wrong");
                $result->data_seek($result->num_rows - 1);
                $row = $result->fetch_assoc();
                $customerID = $row["CustomerID"];    

                // Execute query
                        $query_result = $conn->query($sql);
                        if (!$query_result) {
                            echo "Query is wrong: $sql";
                            die;
                        }

                // Insert data into table
                $table="QUOTE";
                $rent = $_POST['rent'];
                if (is_numeric($rent)) {
                    $sql = "INSERT INTO $table VALUES (null, $customerID, $rent, current_timestamp())";
                    // Execute the query
                    $query_result = $conn->query($sql)
                        or die( "SQL Query ERROR. Data cannot be inserted.");

                    $quoteID = $conn->insert_id;
                    echo "Your order was made successfully. Pick up your order at the counter.";
                } else {
                    echo "Invalid RentID value: $rent";
                }
                
                // prepare SQL query
                // fix the query
                $query = "SELECT *
                                FROM $table, CAR, RENT
                                WHERE QUOTE.RentID = RENT.RentID
                                AND RENT.ReferenceID = CAR.ReferenceID
                                AND QuoteID = $quoteID
                                ORDER BY Date";

                // print the query
                //echo "Query: ".$query."<br>";

                // Execute SQL query
                $result = $conn->query($query)
                or die( "ERROR: Query is wrong");

                // Display results in a table
                $result->data_seek($result->num_rows - 1);
                $row = $result->fetch_assoc();

                // Summarize the order
                echo "<br><b>Order Summary:</b><br>";
                echo "Quote date: " . $row['Date'] . "<br>";
                echo "Quote ID: " . $quoteID . "<br>";
                echo "Reference: " . $row['Reference'] . "<br>";
                echo "Brand: " . $row['Brand'] . "<br>";
                echo "Reference ID: " . $row['ReferenceID'] . "<br>";
                echo "Year: " . $row['Year'] . "<br>";
                echo "Transmission: " . $row['Transmission'] . "<br>";
                echo "Type: " . $row['Type'] . "<br>";
                echo "Rent Fee per mont: $" . $row['RentFee'] . "<br><br>";

                // close the connection with database
                $conn->close();   
            } 
    ?>
    <a href="cars.php"><i class="fa fa-car"></i> Keep watching Cars</a></

    <?php
    include "footer.php";
    ?>
</body>