<?php include_once("../admin/functions.php"); ?>
<?php
    checkLog();
?><?php include_once("../admin/functions.php"); ?>
<?php
    
    if (isset($_GET["option"])){
        if ($_GET["option"]=="currentGuestCheckout"){
           redirect("checkout.php?name=".$_GET["name"]."&roomNo=".$_GET["roomNo"]."&roomType=".$_GET["roomType"]."&checkin=".$_GET["check_in"]."&checkOut=".$_GET["check_out"]);
        }
    }
 ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Front Desk | Guests</title>
    <link href="Styles/styles.css" rel="stylesheet" type="text/css">
    <?php include_once("../admin/classes.php"); ?>
</head>
<body id="guest">
<header>
<?php include("header.php");
?>
</header>
<article>
    <h1>Guest List</h1>
    <div id="guestLinks">
    <ul>
        <a href="reservations.php?reservationOption=new"><li>New</li></a>
        <a href="guests.php?option=currentGuest"><li>Current Guests</li></a>
        <a href="guests.php?option=archivedGuest"><li>Archived Guests</li></a>
        </ul> 
    </div>
    
    <table <?php 
    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
    if ($option=="currentGuest"){ 
        echo 'id="guestTable"';
         }else{
             echo 'id="hide"';
             }
             ?>>
            <tr>
                    <th class="name">Name</th>
                    <th class="room">Room</th>
                    <th class="in">Check in</th>
                    <th class="out">Check Out</th>
                    <th class="outLink"></th>
                </tr>
                <?php
                $option=isset($_GET["option"]) ? $_GET["option"]:"";
                if ($option=="currentGuest"){
                    $guests = new guests();
                    $guests->currentGuests();
                  } 
                ?>
                          
        </table>
          <table <?php $option=isset($_GET["option"]) ? $_GET["option"]:"";
          if ($option=="archivedGuest"){
              echo 'id="archivedGuestTable"';
              }else{
                  echo 'id="hide"';
                  }
                  ?> >
            <tr>
                    <th class="name">Name</th>
                    <th class="room">Room</th>
                    <th class="in">Check in</th>
                    <th class="out">Check Out</th>
                </tr>
                <?php
                $option=isset($_GET["option"]) ? $_GET["option"]:"";
                if ($option=="archivedGuest"){
                    $guests = new guests();
                    $guests->archivedGuests();
                  } 
                ?>
          
        </table>
</article>
<footer>
    <?php include("footer.php");
?>
</footer>
</body>
</html>
