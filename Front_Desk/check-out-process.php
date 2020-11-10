<?php include_once("../admin/functions.php"); ?>
<?php
    checkLog();

    if(!isset($_POST["submit"])){
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
<body id="check-out-process">
<header>
<?php include("header.php");?>
</header>
<article>
    <?php

        //get room number from the POST array
        preg_match_all("!\d+!",$_POST["room"],$matches);
        $roomNumber = $matches[0][0];

        //number of nights
            $checkin = strtotime($_POST["checkInDate"]);
            $checkout = strtotime(date("Y-m-d"));
            $numberOfNights = ($checkout-$checkin)/86400;//seconds for a day

        //find price for the room
        $result = selectWhereLike("rooms","room_no",$roomNumber);

        $row = mysqli_fetch_assoc($result);
        $price = $row["price"];

        //calculate total amount ro rooms;
        $totalAmountForRoom = $price * $numberOfNights;

        //calculate total amount
        $additional = $_POST["additional"];
        $totalAmount = $totalAmountForRoom + $additional;

    ?>
    <form id="paymentProcess" action="forms.php" method="POST">
        <div id="formleft">
        <input type="hidden" name="guestId" value=<?php if(isset($_POST["guestId"])){ echo '"'.$_POST["guestId"].'"';} ?>>
        <div id="fullName"><label>Full Name</label><br/><input type="text" name="fullName" value=<?php if(isset($_POST["fullName"])){ echo '"'.$_POST["fullName"].'"';} ?> readonly></div>

        <div id="checkinDate"><label>Check-in Date</label><br/><input type="text" name="checkin" value=<?php if(isset($_POST["checkInDate"])){ echo '"'.$_POST["checkInDate"].'"';} ?> readonly></div>
        <div id="checkoutDate"><label>Check-out Date</label><br/><input type="text" name="checkout" value=<?php echo '"'.date("Y-m-d").'"'; ?> readonly></div>

        <div id="room"><label>Room</label><br/><input type="text" name="room" value=<?php if(isset($_POST["room"])){ echo '"'.$_POST["room"].'"';} ?> readonly></div>
        </div>
        <div id="formright">
        <div id="total"><label>Number of Nights</label><br/><input type="text" name="numberOfNights" value=<?php echo $numberOfNights; ?> readonly></div>
        <div id="costs"><label>Additional Costs (USD)</label><br/><input type="text" name="costs" value=<?php if(isset($_POST["additional"])){ echo '"'.$_POST["additional"].'"';}?> readonly></div>

        <div id="total"><label>Total Amount (USD)</label><br/><input type="text" name="totalAmount" value=<?php echo $totalAmount; ?> readonly></div>
        <div id="paymentType"><label>Payment Type</label><br/><select name="paymentType"><option>Cash</option><option>Credit Card</option></select></div>
        </div>

        <div id="address"><label>Billing Address</label><br/><textarea name="address" readonly><?php if(isset($_POST["address"])){ echo $_POST["address"];}?></textarea></div>

        <input type="submit" name="submit" value="Check-Out">
    </form>
</article>


<footer>
    <?php include("footer.php");
?>
</footer>
</body>
</html>
