<?php include_once("../admin/functions.php"); ?>
<?php
    checkLog();
?>
<!doctype html>
<?php
//auto refresh page
$page = $_SERVER['PHP_SELF'];
$sec = "10";
?>
<html>

<head>
    <meta charset="utf-8">
    <!--auto refresh page-->
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <title>Front Desk | Status</title>
    <link href="Styles/styles.css" rel="stylesheet" type="text/css">
</head>

<body id="status">
    <header>
        <?php include("header.php"); ?>
        <?php include_once("../admin/classes.php"); ?>
    </header>
    <article>

            <h1>Today's Overview</h1>
            <table id="roomOverviewTable" >
                <tr>
                    <td>Total Rooms</td>
                    <td> <?php $statusInstance = new status();
                                    $allRooms =  $statusInstance->totalRoomCount();
                            echo $allRooms; ?>
                        </td>
                </tr>
                <tr>
                    <td>Occupied Rooms</td>
                    <td> <?php $occRooms =  $statusInstance->occupiedRoomsCount();
                                    if (isset($occRooms)){
                                        echo $occRooms;
                                    }else{
                                        echo 0;
                                    }
                                    ?>
                                    </td>     
                </tr>
                <tr>
                    <td>Available Rooms</td>
                    <td><?php $freeRooms =  $statusInstance->availableRoomCount($allRooms, $occRooms); 
                                echo $freeRooms;
                     ?></td>
                </tr>
                <tr>
                    <td>Available Single-Bed Rooms</td>
                    <td><?php $avbsingle = $statusInstance->availableRoomsByType(); echo $avbsingle["single"]; ?></td>
                </tr>
                <tr>
                    <td>Available Double-Bed Rooms</td>
                    <td><?php echo $avbsingle["double"]; ?></td>
                </tr>
                <tr>
                    <td>Available Family Rooms</td>
                    <td><?php  echo $avbsingle["family"]; ?></td>
                </tr>
            </table>
        <table id="guestOverviewTable">
            <tr>
                    <td>Number of Guests</td>
                    <td><?php  $status = new status(); $guestCount = $status->guests(); echo $guestCount["total"];?></td>
                </tr>
                <tr>
                    <td>Males</td>
                    <td><?php echo $guestCount["male"];  ?></td>     
                </tr>
                <tr>
                    <td>Females</td>
                    <td><?php echo $guestCount["female"]; ?></td>
                </tr>
                <tr>
                    <td>Checking out today</td>
                    <td><?php echo $guestCount["todayCheckOut"];?></td>
                </tr>
                <tr>
                    <td>Unspecified Checkouts</td>
                    <td><?php echo $guestCount["unspecified"];?></td>
                </tr>
        </table>
        <p class="continueDoM"></p>
        <table id="toDoOverviewTable">
            <tr>
            <th>Event</th>
            <th>Time</th>
            </tr>
            <?php $statusInstance->toDoStatus(); ?>
                         
        </table>
        <p></p>
    </article>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>