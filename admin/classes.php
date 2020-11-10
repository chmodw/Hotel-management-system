<?php include_once("../admin/functions.php"); ?>
<?php include_once("dbConnection.php");?>
<?php
  
  class status{

        var $numberOfRooms;
        var $numberOfRoomsByType;
        var $availableRoomsByType;
        var $occupiedRooms;
        var $availableRooms;
        var $count=0;
        var $occupiedOfRoomsByType;
        var $availableRoomTypes;

    function totalRoomCount(){
        //count all rooms in rooms table

        global $numberOfRooms;
        $result = selectAll("rooms");
        while($row=mysqli_fetch_assoc($result)){
            $numberOfRooms++;
        }
        return ($numberOfRooms);
    }

    function occupiedRoomsCount(){
        //counts occupied rooms
        global $occupiedRooms;
        
        $result = selectAll("occupied_rooms");
        while($row=mysqli_fetch_array($result)){


            $checkin = formatDates($row["check_in"]);
            $checkout = formatDates($row["Check_out"]);

            $dateArray=betweenDays($checkin, $checkout);

            if(array_search(date("Y-m-d"),$dateArray)){
                $occupiedRooms+=1;
            }
        }
        // return date("Y-m-d");
       return $occupiedRooms;

    }
    
    function availableRoomCount($numberOfRooms, $occupiedRooms){

        global $availableRooms;
        $availableRooms = $numberOfRooms-$occupiedRooms;

        return ($availableRooms);

    }

    function RoomsByType(){

        global $numberOfRoomsByType;
        global $availableRoomsByType;
        global $count;

        function availableType($roomType){
            //find single,double and family room count from the database
        global $conn;
        global $count;
        $result = selectWhereLike("rooms","room_type",$roomType);
        while ($row=mysqli_fetch_array($result)){
            $count++;
        }

        return ($count);
        
        }
        // call availableType function and sends room type as parameter
        $numberOfRoomsByType["family"] = availableType("Family");
        $count=0;//reset count to 0
        $numberOfRoomsByType["single"] = availableType("Single-Bed");
        $count=0;
        $numberOfRoomsByType["double"] = availableType("Double-Bed");
        $count=0;
        

        return($numberOfRoomsByType);

    }

    function availableRoomsByType(){

        global $numberOfRoomsByType;
        global $occupiedOfRoomsByType;
        global $count;
        global $availableRoomTypes;

        function type($roomType){
        //find single,double and family room count from the database
        global $conn;
        global $count;
        $result = selectWhereLike("occupied_rooms","room_type",$roomType);
        while ($row=mysqli_fetch_array($result)){
            $count++;
        }
        return ($count);
        }

        $occupiedOfRoomsByType["family"] = type("Family");
        $count=0;
        $occupiedOfRoomsByType["single"] = type("Single-Bed");
        $count=0;
        $occupiedOfRoomsByType["double"] = type("Double-Bed");
        $count=0;
        
        $status = new status();
        $numberOfRoomsByType = $status->RoomsByType();
        
        $availableRoomTypes["single"] = $numberOfRoomsByType["single"] - $occupiedOfRoomsByType["single"];
        $availableRoomTypes["double"] = $numberOfRoomsByType["double"] - $occupiedOfRoomsByType["double"];
        $availableRoomTypes["family"] = $numberOfRoomsByType["family"] - $occupiedOfRoomsByType["family"];

        return($availableRoomTypes);

    }

    function guests(){

        $guestTotal=0;
        $guestMale=0;
        $guestFemale=0;
        $todayCheckOuts=0;
        $unspecifiedCheckouts=0;
        $result = selectAll("occupied_rooms");
            while($row=mysqli_fetch_assoc($result)){

                if($row["gender"]=="male"){
                    $guestMale++;

                }elseif($row["gender"]=="female"){
                     $guestFemale++;
                }
                                    
                if($row["Check_out"]==date("d/m/o")){
                $todayCheckOuts++;
                }elseif($row["Check_out"]==""){
                    $unspecifiedCheckouts++;
                }

            $guestTotal++;
            }
                  
           return ($guestCount = array("male"=>$guestMale,"female"=>$guestFemale,"total"=>$guestTotal,"unspecified"=>$unspecifiedCheckouts,"todayCheckOut"=>$todayCheckOuts)); 
         
    }

    function toDoStatus(){

        if($result = selectAll("todo")){
            while($row=mysqli_fetch_assoc($result)){


                $today = formatDates(strtotime("today"));
                $date = formatDates($row["datee"]);


                if($date== $today){
                    echo "<tr>";
                    echo "<td>".$row["action"]."</td>";
                    echo "<td>".$row["timee"]."</td>";
                    echo "</tr>"; 
                }else{
                    echo "<tr>";
                    echo "<td>".$row["action"]."</td>";
                    echo "<td>".$row["timee"]."</td>";
                    echo "</tr>";
                }
        }
        }
    }
}

    class toDo{

        function loadToDoTable(){

            $result = selectAll("todo");
            if($result){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo  "<td>".$row["action"]."</td>";
                echo  "<td>".$row["datee"]."</td>";
                echo  "<td>".$row["timee"]."</td>";
                echo  "<td>"."<a href=todo.php?btn=update&number=".urlencode($row["no"])."&date=".urlencode($row['datee'])."&time=".urlencode($row['timee'])."&action=".urlencode($row['action']).">Edit</a>"."</td>";
                echo "<td>"."<a href=forms.php?optionSpecial=deleteToDo&number=".$row["no"].">cancel</a>"."</td>";
                echo  "</tr>";

        }
     }
    }
}

class guests{
            var $guestId; var $firstName; var $lastName; var $gender; var $idType; var $idNumber; var $phoneNumber; var $address; var $checkin; var $checkOut; var $roomNumber; var $roomType;

    function archivedGuests(){
            $result = selectAll("archived_guests");
            while($row=mysqli_fetch_assoc($result)){
                
                echo "<tr>";
                echo "<td>".$row["first_name"]." ".$row["last_name"]."</td>";
                echo "<td>".$row["room_number"]."-".$row["room_type"]."</td>";
                echo "<td>".$row["check_in"]."</td>";
                echo "<td>".$row["Check_out"]."</td>";
                echo "</tr>";
        }

    }

    function currentGuests(){

            $result = selectAll("occupied_rooms");
            while($row=mysqli_fetch_assoc($result)){

                echo "<tr>";
                echo "<td>".$row["first_name"]." ".$row["last_name"]."</td>";
                echo "<td>".$row["room_number"]."-".$row["room_type"]."</td>";
                echo "<td>".$row["check_in"]."</td>";
                echo "<td>".$row["Check_out"]."</td>";
                echo "<td class='checkout'><a href=checkout.php?id=".urlencode($row["guest_hotel_id"])."&firstName=".urlencode($row["first_name"])."&lastName=".$row["last_name"]."&gender=".urlencode($row["gender"])."&idType=".urlencode($row["id_type"])."&idNumber=".urlencode($row["id_Number"])."&phoneNumber=".urlencode($row["phone_number"])."&address=".urlencode($row["Address"])."&checkIn=".urlencode($row["check_in"])."&checkout=".urlencode($row["Check_out"])."&roomNumber=".urlencode($row["room_number"])."&roomType=".urlencode($row["room_type"]).">Checkout</a></td>";
                echo "</tr>";
            }
        }
    function archiveGuests($guestId){
             //get data from occupied rooms table using guest id
        global $conn;
        if($result = selectWhereLike("occupied_rooms","guest_hotel_id",$guestId)){
            $row = mysqli_fetch_assoc($result);

            //print_r($row);

            $guestId = $row["guest_hotel_id"];
            $firstName = $row["first_name"];
            $lastName = $row["last_name"];
            $gender = $row["gender"];
            $idType = $row["id_type"];
            $idNumber = $row["id_Number"];
            $phoneNumber = $row["phone_number"];
            $address = $row["Address"];
            $checkin = $row["check_in"];
            $checkOut = formatDates("today");
            $roomNumber = $row["room_number"];
            $roomType = $row["room_type"];

            //copy data to archived guests
        $query = "INSERT INTO archived_guests(guest_hotel_id,first_name,last_name,gender,id_type,id_Number,phone_number,Address,check_in,Check_out,room_number,room_type) VALUES ('{$guestId}','{$firstName}','{$lastName}','{$gender}','{$idType}','{$idNumber}','{$phoneNumber}','{$address}','{$checkin}','{$checkOut}',{$roomNumber},'{$roomType}')";

        $result = mysqli_query($conn, $query);

        if($result){
            return ;
        }else{
            return die(mysqli_error($conn));
        }
     }
  }

  function copyToBill($DataArray){
      global $conn;
      $time = Date("Y-m-d H:i");
    $query = "INSERT INTO bills(guest_id,name,checkin,checkout,room,number_of_nights,billing_address,additional,payment_type,total_amount,timee,employee_username) VALUES('{$DataArray["guestId"]}','{$DataArray["fullName"]}','{$DataArray["checkin"]}','{$DataArray["checkout"]}','{$DataArray["room"]}','{$DataArray["numberOfNights"]}','{$DataArray["address"]}','{$DataArray["costs"]}','{$DataArray["paymentType"]}','{$DataArray["totalAmount"]}','{$time}','{$_SESSION["login"]}')";

  $result = mysqli_query($conn, $query);

 if($result){
            return ;
        }else{
            return die(mysqli_error($conn));
        }
 }
}

class reservation{
    //LIMIT 1
    function currentReservation(){

                        $result = selectAll("occupied_rooms");
                         while($row=mysqli_fetch_assoc($result)){
                             echo "<tr>";
                             echo "<td class='checkout'><a href=checkout.php?id=".urlencode($row["guest_hotel_id"])."&firstName=".urlencode($row["first_name"])."&lastName=".$row["last_name"]."&gender=".urlencode($row["gender"])."&idType=".urlencode($row["id_type"])."&idNumber=".urlencode($row["id_Number"])."&phoneNumber=".urlencode($row["phone_number"])."&address=".urlencode($row["Address"])."&checkIn=".urlencode($row["check_in"])."&checkout=".urlencode($row["Check_out"])."&roomNumber=".urlencode($row["room_number"])."&roomType=".urlencode($row["room_type"]).">Checkout</a></td>";

                             echo "<td class=editReservation><a href=reservations.php?reservationOption=new&btn=update&hotelId=".urlencode($row["guest_hotel_id"])."&firstName=".urlencode($row["first_name"])."&lastName=".$row["last_name"]."&gender=".urlencode($row["gender"])."&idType=".urlencode($row["id_type"])."&idNumber=".urlencode($row["id_Number"])."&phoneNumber=".urlencode($row["phone_number"])."&address=".urlencode($row["Address"])."&checkin=".urlencode($row["check_in"])."&checkout=".urlencode($row["Check_out"])."&roomNumber=".urlencode($row["room_number"])."&roomType=".urlencode($row["room_type"]).">Edit</a></td>";

                             echo "<td>".$row["first_name"]."</td>";
                             echo "<td>".$row["last_name"]."</td>";
                             echo "<td>".$row["gender"]."</td>";
                             echo "<td>".$row["id_type"]."</td>";
                             echo "<td>".$row["id_Number"]."</td>";
                             echo "<td>".$row["phone_number"]."</td>";
                             echo "<td>".$row["Address"]."</td>";
                             echo "<td>".$row["check_in"]."</td>";
                             echo "<td>".$row["Check_out"]."</td>";
                             echo "<td>".$row["room_number"]."</td>";
                             echo "<td>".$row["room_type"]."</td>";
                             echo "</tr>";
                         }

    }

     function upcomingReservation(){

         $result = selectAll("occupied_rooms");
                         while($row=mysqli_fetch_assoc($result)){
                             echo "<tr>";
                             echo "<td class='checkout'>Cancel</td>";
                             echo "<td class=editReservation><a href=reservations.php?reservationOption=new&btn=update&hotelId=".urlencode($row["guest_hotel_id"])."&firstName=".urlencode($row["first_name"])."&lastName=".$row["last_name"]."&gender=".urlencode($row["gender"])."&idType=".urlencode($row["id_type"])."&idNumber=".urlencode($row["id_Number"])."&phoneNumber=".urlencode($row["phone_number"])."&address=".urlencode($row["Address"])."&checkin=".urlencode($row["check_in"])."&checkout=".urlencode($row["Check_out"])."&roomNumber=".urlencode($row["room_number"])."&roomType=".urlencode($row["room_type"]).">Edit</a></td>";
                             echo "<td>".$row["first_name"]."</td>";
                             echo "<td>".$row["last_name"]."</td>";
                             echo "<td>".$row["gender"]."</td>";
                             echo "<td>".$row["id_type"]."</td>";
                             echo "<td>".$row["id_Number"]."</td>";
                             echo "<td>".$row["phone_number"]."</td>";
                             echo "<td>".$row["Address"]."</td>";
                             echo "<td>".$row["check_in"]."</td>";
                             echo "<td>".$row["Check_out"]."</td>";
                             echo "<td>".$row["room_number"]."</td>";
                             echo "<td>".$row["room_type"]."</td>";
                             echo "</tr>";
                         }
    }
    
}

class administration{

    function archivedGuestsAdmin(){

                         $result = selectAll("archived_guests");
                         while($row=mysqli_fetch_assoc($result)){
                             echo "<tr>";
                             echo "<td>".$row["guest_hotel_id"]."</td>";
                             echo "<td>".$row["first_name"]."</td>";
                             echo "<td>".$row["last_name"]."</td>";
                             echo "<td>".$row["gender"]."</td>";
                             echo "<td>".$row["id_type"]."</td>";
                             echo "<td>".$row["id_Number"]."</td>";
                             echo "<td>".$row["phone_number"]."</td>";
                             echo "<td>".$row["Address"]."</td>";
                             echo "<td>".$row["check_in"]."</td>";
                             echo "<td>".$row["Check_out"]."</td>";
                             echo "<td>".$row["room_number"]."</td>";
                             echo "<td>".$row["room_type"]."</td>";
                             echo "</tr>";
                         }

    }

    function getRoomInfo(){
        $result = selectAll("rooms");
        while($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row["room_no"]."</td>";
                echo "<td>".$row["room_type"]."</td>";
                echo "<td>".$row["price"]."</td>";
                echo "<td class='details'>".$row["details"]."</td>";
                echo "<td><a href="."administration.php?option=newRoom&roomNo=".urlencode($row["room_no"])."&roomType=".urlencode($row["room_type"])."&price=".urlencode($row["price"])."&details=".urlencode($row["details"]).">edit</a></td>";
                echo "</tr>";
        }
    }

}

?>