<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo $title ?></title>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h3>About My Website</h3>
                <p>The purpose of this website was created for CS 550: Database Concepts course from Computer Science Department at Old Dominion University. Was created for academic and non-professional purposes by Brian Llinas Marimon, PhD student. </p>
                <div class="contact">
                    <span><i class="fa fa-envelope"></i> bllin001@odu.edu</span>
                </div>
                <div class="socials">
                    <a href="https://twitter.com/bllin001"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/in/brian-jesus-llinas-marimon/"><i class="fa fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section contact-form">
                <h3>Contact Us</h3>
                <form action="#" method="post">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Your email address">
                    <textarea name="message" class="text-input contact-input" placeholder="Your message"></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fa fa-envelope"></i>
                        Send
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?php echo date("Y"); ?> CS 550 Final Project. All rights reserved.
        </div>
    </footer>
</body>
</html>

