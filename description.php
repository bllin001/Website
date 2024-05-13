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
        echo "See the information below about your selection"; 
        // Mysql credentials
        $server = "localhost:3306";
        $sqlUsername = "root";
        $sqlPassword = "123456789";
        $databaseName = "project";
        $conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "<br>Connected successfully<br>";

        if(isset($_POST['description'])) {
            $description = $_POST['description'];
            // Fetch the details of the selected row using the reference value
            $sql = "SELECT RentID, Reference, Brand, Year, Type, Transmission, RentFee
                        FROM CAR, RENT 
                        WHERE CAR.ReferenceID = RENT.ReferenceID 
                        AND Reference='$description'";
            // execute the query and retrieve the result
            $result = $conn->query($sql);
            // then display the result in a new table
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
                    echo "<td><form method='POST' action='quote.php'>
                                    <button type='submit' name='rent' value='".$row['RentID']."'>Rent</button>
                                    
                                </form></td>";
                    echo "</tr>\n";
                    echo "</tr>\n";
                    $i++;
                }
            echo "</table><br>";
        }
    ?>

    <a href="cars.php"><i class="fa fa-arrow-left"></i> Back to Cars</a>

    <?php
    include "footer.php";
    ?>
</body>
</html>
