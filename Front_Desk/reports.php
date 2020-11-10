<?php include_once("../admin/functions.php"); ?>
<?php include_once("../admin/classes.php"); ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Front Desk | Reports</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body id="home">
<header>
    <?php include("header.php"); ?>
</header>
<article>
<?php

if (isset($_GET["submit"])){


    if ($_GET["submit"]=="Generate") {

        echo "<p style='clear: both'></p>";

        echo "<p style='font-size:20px;margin: 30px; text-align: center'>{$_GET['month']} Month Report</p>";
        $data = 0;

        $data = "
                <table class='reportTable'>
                <tr>
                    <td>Name</td>
                    <td>Check-In</td>
                    <td>Check-Out</td>
                    <td>Room</td>
                    <td>No.of Nights</td>
                    <td>additional</td>
                    <td>Total Amount</td>
                </tr>";

$total = 0;
$result = selectAll("bills");

while ($row = mysqli_fetch_assoc($result)) {

    if ($row["checkout"][5] . $row["checkout"][6] == $_GET["month"]) {


        $data .= "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['checkin'] . "</td>
                            <td>" . $row['checkout'] . "</td>
                            <td>" . $row['room'] . "</td>
                            <td>" . $row['number_of_nights'] . "</td>
                            <td>" . $row['additional'] . "</td>
                            <td>" . $row['total_amount'] . "</td>
                            </tr>";
        $total += $row['total_amount'];

    }
}


        $data .= "<tr>
                            <td>" ."</td>
                            <td>" ."</td>
                            <td>" . "</td>
                            <td>" . "</td>
                            <td>" . "</td>
                            <td>" . "</td>
                            <td>" . 'Total Income : '.$total ."</td>
                            </tr>";

        $data .= "</table>";

        echo $data;
    }

}elseif (isset($_GET["Year_Report"]) && $_GET["Year_Report"]=="Generate"){

    $totalMonth = 0;
    $totalYear = 0;
    $noOfGuests = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $months = array(0,0,0,0,0,0,0,0,0,0,0,0);

    echo "<p style='clear: both'></p>";

    echo "<p style='font-size:20px;margin: 30px; text-align: center''>{$_GET['year']} Year Report</p>";

    $data = "
                <table class='reportTable'>
                <tr>
                    <td>Month</td>
                    <td>No.of guests</td>
                    <td>Total Income</td>
                </tr>";

$result = selectAll("bills");

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row["checkout"][0].$row["checkout"][1].$row["checkout"][2].$row["checkout"][3] == $_GET["year"]) {


            for ($x = 1; $x<=9;$x++){

                if($row["checkout"][5].$row["checkout"][6] == "0".$x){
                    $months[$x-1]+=$row["total_amount"];
                    $noOfGuests[$x-1]+=1;
                    $totalYear+=$row["total_amount"];
                }
            }

            if($row["checkout"][5].$row["checkout"][6] == 10){
                $months[10]+=$row["total_amount"];
                $noOfGuests[10]+=1;
                $totalYear+=$row["total_amount"];
            }elseif($row["checkout"][5].$row["checkout"][6] == 11){
                $months[11]+=$row["total_amount"];
                $noOfGuests[11]+=1;
                $totalYear+=$row["total_amount"];
            }elseif($row["checkout"][5].$row["checkout"][6] == 12){
                $months[12]+=$row["total_amount"];
                $noOfGuests[12]+=1;
                $totalYear+=$row["total_amount"];
            }

        }else{

        }

    }

        $data .= "<tr>
                            <td>" .'january'. "</td>
                            <td>" .$noOfGuests[0]. "</td>
                            <td>" .$months[0]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'February'. "</td>
                            <td>" .$noOfGuests[1]. "</td>
                            <td>" .$months[2]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'March'. "</td>
                            <td>" .$noOfGuests[2]. "</td>
                            <td>" .$months[2]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'April'. "</td>
                            <td>" .$noOfGuests[3]. "</td>
                            <td>" .$months[3]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'May'. "</td>
                            <td>" .$noOfGuests[4]. "</td>
                            <td>" .$months[4]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'June'. "</td>
                            <td>" .$noOfGuests[5]. "</td>
                            <td>" .$months[5]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'july'. "</td>
                            <td>" .$noOfGuests[6]. "</td>
                            <td>" .$months[6]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'August'. "</td>
                            <td>" .$noOfGuests[7]. "</td>
                            <td>" .$months[8]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'September'. "</td>
                            <td>" .$noOfGuests[8]. "</td>
                            <td>" .$months[8]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'October'. "</td>
                            <td>" .$noOfGuests[9]. "</td>
                            <td>" .$months[9]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'November'. "</td>
                            <td>" .$noOfGuests[10]. "</td>
                            <td>" .$months[10]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" .'December'. "</td>
                            <td>" .$noOfGuests[11]. "</td>
                            <td>" .$months[11]. "</td>
                            </tr>";
    $data .= "<tr>
                            <td>" . "</td>
                            <td>" . "</td>
                            <td>" .'Total Income = '.$totalYear. "</td>
                            </tr>";

    $data .= "</table>";

    echo $data;




}elseif(isset($_GET["option"]) && $_GET["option"]=="currentStatus") {

    $statusInstance = new status();
    $totalRooms =  $statusInstance->totalRoomCount();

    $occRooms =  $statusInstance->occupiedRoomsCount();
    if (isset($occRooms)){
        $ocRooms = $occRooms;
    }else{
       $ocRooms = 0;
    }

    $freeRooms =  $statusInstance->availableRoomCount($totalRooms, $occRooms);
    $avbsingle = $statusInstance->availableRoomsByType(); $single = $avbsingle["single"];
    $double = $avbsingle['double'];
    $family = $avbsingle["family"];
    $status = new status(); $guestCount = $status->guests(); $guests = $guestCount["total"];
    $male = $guestCount["male"];
    $female = $guestCount["female"];
    $todayCheckouts = $guestCount["todayCheckOut"];

    echo "<p style='clear: both'></p>";
    echo "<p p style='font-size:20px;margin: 30px; text-align: center''>Today's Status Report</p>";
    $data ="<table class='reportTable' style='width: 500px;margin-left: 230px;'>";

    $data .= "<tr>
                <td>Total Rooms</td>
                <td>$totalRooms</td>
              </tr>";
    $data .= "<tr>
                <td>Occupied Rooms</td>
                <td>$ocRooms</td>
              </tr>";
    $data .= "<tr>
                <td>Available Rooms</td>
                <td>$freeRooms</td>
              </tr>";
    $data .= "<tr>
                <td>Available Single-Bed Rooms</td>
                <td>$single</td>
              </tr>";
    $data .= "<tr>
                <td>Available Double-Bed Rooms</td>
                <td>$double</td>
              </tr>";
    $data .= "<tr>
                <td>Available Family Rooms</td>
                <td>$family</td>
              </tr>";
    $data .= "<tr>
                <td>Number of Guests</td>
                <td>$guests</td>
              </tr>";
    $data .= "<tr>
                <td>Males</td>
                <td>$male</td>
              </tr>";
    $data .= "<tr>
                <td>Males</td>
                <td>$female</td>
              </tr>";
    $data .= "<tr>
                <td>Checking out today</td>
                <td>$todayCheckouts</td>
              </tr>";

    $data .="</table>";

    echo $data;
}elseif($_GET["option"] == "roomStatus") {

    echo "<p style='clear: both'></p>";
    echo "<p p style='font-size:20px;margin: 30px; text-align: center''>Rooms Status Report</p>";
    $tableData = "<table class='reportTable' style='margin-top: 30px;'>
<tr>
<td>Room No</td>
<td>Guest Name</td>
<td>Check-In</td>
<td>Check-Out</td>
<td>No.Of Nights</td>
</tr>";


    $result = selectAll("rooms");
    while ($row = mysqli_fetch_assoc($result)){

        $result2 =selectWhereLike("occupied_rooms","room_number",$row["room_no"]);

        if($result2){
            $row2 = mysqli_fetch_assoc($result2);

            $checkin = strtotime($row2["check_in"]);
            $checkout = strtotime($row2["Check_out"]);
            $numberOfNights = ($checkout-$checkin)/86400;

            $tableData .= "<tr>
<td>{$row['room_no']}</td>
<td>{$row2['first_name']} {$row2['last_name']}</td>
<td>{$row2['check_in']}</td>
<td>{$row2['Check_out']}</td>
<td>{$numberOfNights}</td>
</tr>";

        }else{
            $tableData .= "<tr>
<td>{$row['room_no']}</td>
<td>Not Reserved</td>
<td>Not Reserved</td>
<td>Not Reserved</td>
<td>Not Reserved</td>
</tr>";
        }

    }
    $tableData .= "</table>";

    echo $tableData;

}else{redirect($_SERVER['HTTP_REFERER']);

}


?>

</article>
<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
