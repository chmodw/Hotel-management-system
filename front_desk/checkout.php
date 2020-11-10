<?php include_once("../admin/functions.php"); ?>
<?php
    checkLog();

    if(!isset($_GET["firstName"])){
        redirect($_SERVER['HTTP_REFERER']);
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Front Desk | CheckOut</title>
    <link href="Styles/styles.css" rel="stylesheet" type="text/css">
    <?php include_once("../admin/classes.php"); ?>
</head>
<body id="guest">
<header>
<?php include("header.php");?>
</header>
<article>

    <form id="payment" action="check-out-process.php" method="POST">
    <input type="hidden" name="guestId" value=<?php if(isset($_GET["id"])){ echo '"'.$_GET["id"].'"'; }?>>
        <label>Full Name</label><br/><input type="text" name="fullName" value=<?php if(isset($_GET["firstName"])){ echo '"'.$_GET["firstName"].' '.$_GET["lastName"].'"';} ?> readonly>
        <br/>
        <label>Check-in Date</label><br/><input type="text" name="checkInDate" value=<?php if(isset($_GET["checkIn"])){ echo '"'.$_GET["checkIn"].'"';} ?> readonly>
        <br/>
        <label>Check-out Date</label><br/><input type="text" name="checkOutDate" value=<?php echo '"'.date("Y-m-d").'"'; ?> readonly>
        <br/>
        <label>Room</label><br/><input type="text" name="room" value=<?php if(isset($_GET["roomNumber"])){ echo '"'.$_GET["roomNumber"]."-".$_GET["roomType"].'"';} ?> readonly>
        <br/>
        <label>Billing Address</label><br/><textarea name="address" readonly><?php if(isset($_GET["address"])){ echo $_GET["address"];}?></textarea>
        <br/>
        <label>Additional Costs (USD)</label><br/><input type="text" name="additional" value=0>
        <br/>
        <input type="submit" name="submit" value="Process">       
    </form>
</article>
<footer>
    <?php include("footer.php");
?>
</footer>
</body>
</html>