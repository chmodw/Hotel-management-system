<?php include_once("../admin/functions.php"); ?>
<?php
   checkLog();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Front Desk | Reservations</title>
    <?php include("header.php"); ?>
    <?php include_once("../admin/classes.php"); ?>
</head>
<body id="reservations">
<article>
<br>

 <ul id="reservationNav">

        <a href="reservations.php?reservationOption=new"><li>New</li></a>
        <a href="reservations.php?reservationOption=current"><li> Reservations</li></a>
        <a href="reservations.php?reservationOption=online"><li>Online Reservations</li></a>
    </ul>
    <form action="forms.php" method="POST"
    <?php

    $option=isset($_GET["reservationOption"]) ? $_GET["reservationOption"]: "";

    if ($option == "new"){
        echo 'id="reservationForm"';
    }else{
        echo 'id="hide"';
    }

    ?>>
        <input type="hidden" name="guestHotelId" value=<?php echo '"'.getCheck("hotelId","hotelId","").'"'; ?>>
            Check In: <input type="date" name="CheckIn" placeholder="YYYY-MM-DD" value=<?php echo '"'.getCheck("checkin","checkin","").'"'; ?>>
            Check Out: <input type="date" name="checkout" placeholder="YYYY-MM-DD" value=<?php echo '"'.getCheck("checkout","checkout","").'"'; ?>>
            <input type="submit" name="submit" value="Available Rooms">
            <br/>      
            Available Rooms : <select name="roomNumber">
           <?php
           if(isset($_GET["checkin"])){
           if(!$_GET["roomNumber"]==""){
                echo "<option>";
        
                $result = selectWhereLike("rooms","room_no",$_GET["roomNumber"]);
                $row = mysqli_fetch_assoc($result);
                
                echo $row["room_no"]."-".$row["room_type"]." ".$row["price"]."usd";
                echo "</option>";
                echo "<option>";
                 echo "---Available Rooms---";
                echo "</option>";
           }                  
            $dates = $_SESSION["availableDates"];
               
               for($x=0;sizeof($dates)>=$x;$x++){
                echo "<option>";
                //select room number from rooms table and extract the room type
                $result = selectWhereLike("rooms","room_no",$x+1);
                $row = mysqli_fetch_assoc($result);
                
                echo $dates[$x]."-".$row["room_type"]." ".$row["price"]."usd";

                echo "</option>";
               }         
           }else{
               echo "";
           }              
           ?>
            </select>
            <br/>

            <input type="text" name="firstName" placeholder="First Name" class="name" value=<?php echo '"'.getCheck("firstName","firstName","").'"'; ?>>
            <input type="text" name="lastName" placeholder="Last Name" value=<?php echo '"'.getCheck("firstName","lastName","").'"'; ?>>
            <br/>
            Gender: <input type="radio" name="gender" value="male" <?php if(getCheck("firstName","gender","")=="male"){echo 'checked="checked"';} ?> /> Male <input type="radio" name="gender" value="female" <?php if(getCheck("firstName","gender","")=="female"){echo 'checked="checked"';} ?> /> Female
            <br/>
            ID Type: <select name="idType" ><option <?php if(getCheck("firstName","idType","")=="International Passport"){echo 'checked="true"';} ?>>International Passport</option><option <?php if(getCheck("firstName","idType","")=="Identity card"){echo 'checked="true"';} ?>>Identity card</option></select>

            <input type="text" name="idNumber" placeholder="ID Number" value=<?php echo '"'.getCheck("firstName","idNumber","").'"'; ?>>

            <input type="text" name="phoneNumber" placeholder="Phone Number" value=<?php echo '"'.getCheck("firstName","phoneNumber","").'"'; ?>>
            <br/>

            <textarea rows="6" name="address" placeholder="Address"><?php echo getCheck("address","address","");?></textarea>
            <br/>

                <?php if(isset($_GET["message"])){echo '<p id="message">'.$_GET["message"]; $_GET["message"]=""."</p>";}else echo ""; ?>
                <br/>

            <input type="submit" name="submit" value=<?php if(isset($_GET["btn"])){echo '"Update"';}else{echo '"Reserve"';}?>>

    </form>
    <div <?php

    $option=isset($_GET["reservationOption"]) ? $_GET["reservationOption"]: "";

    if ($option == "current"){
        echo 'id="currentReservations"';
    }else{
        echo 'id="hide"';
    }

    ?>>
        <table id="currentReservationTable">
            <tr>
                    <td class=checkout></td>
                    <td class=edit></td>
                    <th class="fname">First Name</th>
                    <th class="lname">Last Name</th>
                    <th class="gender">Gender</th>
                    <th class="idType">ID Type</th>
                    <th class="idNumber">ID Number</th>
                    <th class="phone">Phone number</th>
                    <th class="address">Address</th>
                    <th class="checkin">Check In</th>
                    <th class="check_out">Check Out</th>
                    <th class="roomNo">Room Number</th>
                    <th class="roomType">Room Type</th>
                </tr> 
                <?php
                     $current = new reservation();
                     $current->currentReservation();
                   ?>

        </table>
    </div>


<div <?php

    $option=isset($_GET["reservationOption"]) ? $_GET["reservationOption"]: "";

    if ($option == "online"){
        echo 'id="online"';
    }else{
        echo 'id="hide"';
    }

    ?>

hello



<p style="clear: both"></p>
</article>
<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
