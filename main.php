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
    $title = "Welcome to my webpage";
    include "header.php";
    ?>
        <main>
            <section class="hero">
                <h1>Lease a car</h1>
                <p>Get your dream car today with our flexible leasing options. </p>
                <a href="cars.php">Rent a car</a>
            </section>
            <section class="benefits">
                <h2>Why lease a car?</h2>
                <ul>
                    <li>Low upfront costs</li>
                    <li>Flexible payment options</li>
                    <li>No hassle of maintenance and repairs</li>
                    <li>Ability to drive a new car every few years</li>
                </ul>
            </section>
            <section class="features">
                <h2>Our features</h2>
                <ul>
                    <li>Wide selection of cars to choose from</li>
                    <li>Competitive pricing and special offers</li>
                    <li>Easy online booking and payment system</li>
                    <li>24/7 customer support and assistance</li>
                </ul>
            </section>
        </main>
        <img src="image.jpg" alt="sample image">
        
    <?php
    include "footer.php";
    ?>
</body>
</html>