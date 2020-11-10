<?php include_once("../admin/functions.php"); ?>
 <?php include_once("../admin/classes.php"); ?>
<?php

    checkLog();

    $username = $_SESSION["login"];
    $sql = "SELECT * FROM user WHERE username ='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if($row["account_level"]!=="admin"){

        echo "<script type='text/javascript'> alert('You Need Login as a admin to use Administration Page')</script>";

        redirect($_SERVER['HTTP_REFERER']);//redirect to previous page

    }
    
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Front Desk | Administration</title>
    <link href="Styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body id="home">
<header>
<?php include("header.php"); ?>
</header>
<article>

    <br>
    <ul id="adminNav">
        <a href="administration.php?option=newUser"><li>New User</li></a>
        <a href="administration.php?option=newRoom"><li>New Room</li></a>
        <a href="administration.php?option=editRoom"><li>Rooms</li></a>
        <a href="administration.php?option=viewUser"><li>View Users</li></a>
        <a href="administration.php?option=archivedGuests"><li>Archived Guests</li></a>
        <a href="administration.php?option=reports"><li>Reports</li></a>
        <a href="administration.php?option=customerMessages"><li>Customer Messages</li></a>
    </ul>

    <div <?php 
    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
    if ($option=="archivedGuests"){ 
        echo 'id="adminSide"';
         }else{
             echo 'id="hide"';
             }
             ?>>
        <p style="clear: both"></p>
    <table id="adminTable">
            <tr>
                    <th class="id">Guest_HotelID</th>
                    <th class="fname">First_Name</th>
                    <th class="lname">Last_Name</th>
                    <th class="gender">Gender</th>
                    <th class="idType">ID_Type</th>
                    <th class="idNumber">ID_Number</th>
                    <th class="phone">Phone_number</th>
                    <th class="address">Address</th>
                    <th class="checkin">Check_In</th>
                    <th class="checkout">Check_Out</th>
                    <th class="roomNo">Room_Number</th>
                    <th class="roomType">Room_Type</th>
                </tr> 
                <?php
                     $roomInfo = new administration();
                     $roomInfo->archivedGuestsAdmin();
                   ?>

        </table>
        </div>

        <div <?php 
                    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
                    if ($option=="newUser"){ 
                     echo 'id="newUser"';
                     }else{
                          echo 'id="hide"';
                     }
             ?>>

            <form action="forms.php" method="POST">

                <label for="username">Username</label><br/><input type="text" name="username" placeholder="Username" maxlength="10" size="10" value=<?php if(isset($_GET["usernameBack"])){ echo '"'.$_GET["usernameBack"].'"'; }else{echo '"'."".'"';}?>>
                <br/>
                <label for="fullName">Full Name</label><br/><input type="text" name="fullName" placeholder="Full Name" maxlength="24" size="24" value=<?php if(isset($_GET["fullNameBack"])){ echo '"'.$_GET["fullNameBack"].'"'; }else{echo '"'."".'"';}?>>
                <br/>
                <label for="password">Password</label><br/><input type="password" name="password" placeholder="Password"  maxlength="16" size="16" />
                <br/>
                <label for="confirmPassword">Confirm Password</label><br/><input type="password" name="confirmPassword" maxlength="16" size="16" placeholder="Confirm Password"/>
                <br/>
                <p><?php if(isset($_GET["message"])){ echo $_GET["message"];}?></p>
                <br/>
                User Level : <select name="userLevel"><option>user</option><option>admin</option></select>
                <option></option>
                <br/>
                <p><input type="submit" name="submit" value="Save User"/></p>
            </form>
    
    </div>
        <div <?php 
                    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
                    if ($option=="editRoom"){ 
                     echo 'id="editRoom"';
                     }else{
                          echo 'id="hide"';
                     }
             ?>>

             <table>
                 <tr>
                     <th>Room Number</th>
                     <th>Room Type</th>
                     <th>Price</th>
                     <th>Details</th>
                 </tr>
                    <?php
                        $roomInfo->getRoomInfo();
                    ?>
             </table>
    
    </div>
        <div <?php 
                    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
                    if ($option=="newRoom"){ 
                     echo 'id="newRoom"';
                     }else{
                          echo 'id="hide"';
                     }
             ?>>

              <form action="forms.php" method="POST">

                <label for="roomNumber">Room Number</label>
                <br>
                <select name="roomNumber">
                    <option><?php 

                    if(isset($_GET["roomType"])){
                        echo $_GET["roomNo"];
                    }else{
                    $roomnu = new status();
                    $roomcount = $roomnu->totalRoomCount(); 
                    echo $roomcount+=1;
                    }
                    ?></option>
                </select>
                <br/>
                <label for="roomType">Room Type</label><br/><input type="text" name="roomType" placeholder="ex - Single-Bed" value=<?php 
                    if(isset($_GET["roomType"])){ echo '"'.$_GET["roomType"].'"';}else{echo '"'."".'"';}?>/>
                <br/>
                <label for="price">Price</label><br/><input type="text" name="price" placeholder="Without $ sign'" value=<?php 
                    if(isset($_GET["roomType"])){ echo '"'.$_GET["price"].'"';}else{echo '"'."".'"';}?>/>
                <br/>
                <label for="details">Details</label><br/><textarea name="details" value=><?php 
                    if(isset($_GET["roomType"])){ echo $_GET["details"];}else{echo "";}?></textarea>
                <br/>
                <p><?php if(isset($_GET["message"])){ echo $_GET["message"];}?></p>
                <br/>
                <p><input type="submit" name="submit" value=<?php 
                    if(isset($_GET["roomType"])){ echo '"'."update Room".'"';}else{echo '"'."Save Room".'"';}?>></p>
            </form>
    
    </div>
      <div <?php 
    $option=isset($_GET["option"]) ? $_GET["option"]:""; 
    if ($option=="viewUser"){ 
        echo 'id="viewUser"';
         }else{
             echo 'id="hide"';
             }
             ?>>
    <table>
            <tr>
                    <th style="width:250px" >Full Name</th>
                    <th style="width:170px" >Username</th>
                    <th style="width:130px" >Account Level</th>
                </tr> 
                <?php
                     $result = selectAll("user");
                     while($row = mysqli_fetch_assoc($result)){
                         echo "<tr>";
                         echo "<td>".$row["Full_name"]."</td>";
                         echo "<td>".$row["username"]."</td>";
                        //  echo "<td>".$row["password"]."</td>";
                         echo "<td>".$row["account_level"]."</td>";
                         echo "<td>"."<a href=forms.php?optionSpecial=deleteuser&username={$row["username"]}>delete</a>"."</td";
                         echo "<tr>";
                     }
                   ?>

        </table>
        </div>
    <div <?php
    $option=isset($_GET["option"]) ? $_GET["option"]:"";
    if ($option=="reports"){
        echo 'id="reports"';
    }else{
        echo 'id="hide"';
    }
    ?>>

        <p>Income (Month) :
                <form action="reports.php" method="get"> <input type="text" name="month"> <input type="submit" name="submit" value="Generate"></form>
        </p>
        <p>Income (Year) :
                <form action="reports.php" method="get"> <input type="text" name="year"> <input type="submit" name="Year_Report" value="Generate"></form>
        </p>
        <br>

        <p><a href="reports.php?option=currentStatus">Current Hotel Status report</a></p>
        <br>
        <br>

        <p><a href="reports.php?option=roomStatus">Rooms Status Report</a></p>

    </div>

    <div <?php
    $option=isset($_GET["option"]) ? $_GET["option"]:"";
    if ($option=="customerMessages"){
        echo 'id="customerMessages"';
    }else{
        echo 'id="hide"';
    }
    ?>>

        <table>
            <tr>
                <th style="width:130px" >Name</th>
                <th style="width:170px" >E-mail</th>
                <th style="width:130px" >Subject</th>
                <th style="width:250px" >Message</th>
            </tr>
            <?php
            $result = selectAll("customer_messages");
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row["customerName"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["subject"]."</td>";
                echo "<td>".$row["message"]."</td>";

                echo "<tr>";
            }

            ?>
        </table>



    </div>
            <?php if(isset($_GET["message"])){echo '<p id="message">'.$_GET["message"]; $_GET["message"]=""."</p>";}else echo ""; ?>

</article>
<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
