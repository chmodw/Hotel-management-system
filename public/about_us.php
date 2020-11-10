<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>NEARBEACH | Contact Us</title>
    <link href="Styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body id="home">
<header>
<?php include("header.php"); ?>
</header>
<article>

    <img src="img/contact-us-header-c7beb6c5.jpg" width="960" height="510" title="Contact Us Header" class="mainimg" >



        <div id="contact">
            <div id="aboutP">
            <p>Contact Us</p>
            <p>If you wish to obtain more information about NEARBEACH Hotel you can call us, email us or even contact us via post.</p>
            <p>
                NEARBEACH Hotel
                <br>
                Address : No 33, beach road, Negombo, Sri lanka
                <br>
                Tel : +94 77 2024897
                <br>
                Fax : +94 55 3355456
                <br>
                E-Mail : nearbeach@nb.lk
                <br>
                Web: www.nearbeach.lk

            </p>
        </div>

        <form action="forms.php" method="post">
            <p>Get in Touch with us!</p>
            <input type="text" name="name" placeholder="Name">
            <br>
            <input type="text" name="email" placeholder="E-Mail">
            <br>
            <input type="text" name="subject" placeholder="Subject">
            <br>
            <textarea name="message" placeholder="Message"></textarea>
            <br>
            <input type="submit" name="submit" value="Send">
            <br/>

            <?php if(isset($_GET["message"])){echo '<p id="message">'.$_GET["message"]; $_GET["message"]=""."</p>";}else echo ""; ?>
            <br/>
        </form>
            <p style="clear: both"></p>
    </div>
</article>
<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>