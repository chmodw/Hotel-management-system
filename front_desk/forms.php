<?php include_once("../admin/functions.php"); ?>
<?php include_once("../admin/classes.php"); ?>

<?php 
//=====================================================================================================================================//

    if(($_POST["submit"]=="Login")){

        if (isEmpty($_POST["username"]) && isEmpty($_POST["password"])){
     
            
            $username = mysqli_real_escape_string($conn,$_POST["username"]);
            $password = mysqli_real_escape_string($conn,$_POST["password"]);

            //echo password_hash($password, PASSWORD_DEFAULT, ["cost" =>12]);

            $sql = "SELECT * FROM user WHERE username='$username'";
            $result = mysqli_query($conn, $sql);

            if($row = mysqli_fetch_assoc($result)){
                
                $cryPassword = $row["password"];

                    if (password_verify($password,$cryPassword)){
                        $_SESSION["login"] = $username;
                        redirect("status.php");
                    }else{
                        redirect("index.php?message=Username/Password+is+Incorrect");
                     }

            }else{
                redirect("index.php?message=Username/Password+is+Incorrect");
            }
        }else{
            redirect("index.php?message=Please+insert+username/password");
        }

  //=================================================================================================================//      

    }elseif($_POST["submit"]=="Save User"){

        print_r($_POST);
    

        if (isEmpty($_POST["username"]) && isEmpty($_POST["fullName"]) && isEmpty($_POST["password"]) && isEmpty($_POST["confirmPassword"])){

            if($_POST["password"] !== $_POST["confirmPassword"]){

                redirect("administration.php?option=newUser&message=Passwords+dose+not+Match&usernameBack=".$_POST["username"]."&fullNameBack=".urlencode($_POST["fullName"]));

            }else{
                //check for unique username
                $username = mysqli_real_escape_string($conn,$_POST["username"]);
                global $conn;
                $query = "SELECT username FROM user WHERE username = "."'".$username."'";
                $result = mysqli_query($conn, $query) or die(mysqli_error());
                $checkid = mysqli_num_rows($result);
                if($checkid>0){
                    redirect("administration.php?option=newUser&message=username+is+already+exist+in+database");
                }else{

             //escape user inputs
            $username = mysqli_real_escape_string($conn,$_POST["username"]);
            $fullName = mysqli_real_escape_string($conn,$_POST["fullName"]);
            $password = mysqli_real_escape_string($conn,$_POST["password"]);
            $userLevel = $_POST["userLevel"];

            //password Encryption 
            $cry_password = password_hash($password, PASSWORD_BCRYPT, array("cost" =>12));

            $query = "INSERT INTO user (Full_name,username,password,	account_level) VALUES ('{$fullName}','{$username}','{$cry_password}','{$userLevel}')";
            $result = mysqli_query($conn, $query);

            if($result){
                    redirect("administration.php?option=newUser&message=Saved");
                 }else{
                    
                redirect("administration.php?option=newUser&message=Something+Wrong+with+the+Database+Please+Contact+System+Administrator");
                }
                
            }
        }

        }else{
            redirect("administration.php?option=newUser&message=Please+complete+all+the+data");
        }
    

//==================================================================================================================//

    }elseif($_POST["submit"]=="Check-Out"){
    global $conn;
        $guestId = $_POST["guestId"];
        $guests = new guests();

        //copy row to archived guests
        //error variable get return values true or false
        $error1 = $guests->archiveGuests($guestId);
        //copy data to bills
        $error2 = $guests->copyToBill($_POST);
        //delete row form the occupied table and free the room
        $query = "DELETE FROM occupied_rooms WHERE guest_hotel_id='".$guestId."' LIMIT 1";
        if($result = mysqli_query($conn,$query)){

        }else{
            $error3 = "something went wrong when deleting the reservation";
        }


        if ($error1 && $error2 && $error3){
            echo $error1;
            echo $error2;
            echo $error3;
        }else{
            redirect("guests.php");
        }

}elseif($_POST["submit"]=="Available Rooms"){
    //array_diff () Differance//array_intersect()

        if($_POST["CheckIn"] || $_POST["checkout"]=="") {

            if (strtotime($_POST["CheckIn"]) > strtotime($_POST["checkout"])) {
                // check check-in date is less than check-out
                redirect("reservations.php?message=Wrong+Date+Combination&reservationOption=new");

            }else{


                $availableDates = availableDates($_POST["CheckIn"],$_POST["checkout"]);

                $_SESSION["availableDates"] = $availableDates;

                redirect("reservations.php?checkin={$_POST["CheckIn"]}&checkout={$_POST["checkout"]}&reservationOption=new");

            }
        }else {
            redirect("reservations.php?message=Please+Enter+Checkin+And+checkout+dates&reservationOption=new");
        }


}elseif($_POST["submit"]=="Reserve"){

   if($_POST["Checkin"] || $_POST["checkout"] || $_POST["firstName"] || $_POST["lastName"] || $_POST["gender"] || $_POST["idType"] || $_POST["idNumber"] || $_POST["phoneNumber"] || $_POST["address"] !==""){

    //Array ( [CheckIn] => 2017-05-29 [checkout] => 2017-06-02 [roomNumber] => 1-Single-Bed 37usd [firstName] => c [lastName] => c [gender] => male [idType] => International Passport [idNumber] => c [phoneNumber] => c [address] => c [submit] => Reserve ) 

    $checkin =  mysqli_real_escape_string($conn,$_POST["CheckIn"]);
     $checkin = formatDates($checkin);
    $checkout =  mysqli_real_escape_string($conn,$_POST["checkout"]);
     $checkout = formatDates($checkout);
    $room = mysqli_real_escape_string($conn,$_POST["roomNumber"]);
    $firstName =  mysqli_real_escape_string($conn,$_POST["firstName"]);
    $lastName =  mysqli_real_escape_string($conn,$_POST["lastName"]);
    $gender =  mysqli_real_escape_string($conn,$_POST["gender"]);
    $idType =  mysqli_real_escape_string($conn,$_POST["idType"]);
    $idNumber =  mysqli_real_escape_string($conn,$_POST["idNumber"]);
    $phoneNumber =  mysqli_real_escape_string($conn,$_POST["phoneNumber"]);
    $address =  mysqli_real_escape_string($conn,$_POST["address"]);
    

    //generate guest hotel ID
  //  $guestId = substr($firstName,-1);
    $guestId =md5($firstName[0].substr($firstName,-1).$lastName.substr($lastName,-1)[0].Date("ymm").time("h:m"));   

    //room number and room type
    $roomNumber = $room[0];

    $result = selectWhereLike("rooms","room_no",$roomNumber);
    $row = mysqli_fetch_assoc($result);
    $roomType = $row["room_type"];

     $query = "INSERT INTO occupied_rooms (guest_hotel_id,first_name,last_name,gender,id_type,id_number,phone_number,Address,check_in,Check_out,room_number,room_type) VALUES ('{$guestId}','{$firstName}','{$lastName}','{$gender}','{$idType}','{$idNumber}','{$phoneNumber}','{$address}','{$checkin}','{$checkout}','{$roomNumber}','{$roomType}')"; 

     $result = mysqli_query($conn,$query);

     if($result){
              redirect("reservations.php?message=Saved&reservationOption=new");
     }else{
         redirect("reservations.php?message=Something+Went+wrong+Please+Contact+system+administrator&reservationOption=new");
     }

      $_SESSION["availableDates"]="";

      }else{

      redirect("reservations.php?message=Please+Enter+Required+Information&reservationOption=new&checkin={$_POST['CheckIn']}&checkout={$_POST['checkout']}&firstName={$_POST['firstName']}&lastName={$_POST['lastName']}&gender={$_POST['gender']}&idType={$_POST['idType']}&idNumber={$_POST['idNumber']}&phoneNumber={$_POST['phoneNumber']}&address={$_POST['address']}&roomNumber={$_POST['roomNumber']}");
   

  
   }

    //==================================================================//



}elseif($_POST["submit"]=="Update"){

   if($_POST["Checkin"] || $_POST["checkout"] || $_POST["firstName"] || $_POST["lastName"] || $_POST["gender"] || $_POST["idType"] || $_POST["idNumber"] || $_POST["phoneNumber"] || $_POST["address"] !==""){

//Array ( [guestHotelId] => 589ae15b7304f69f8146e303bf869475firstName=wimansha [CheckIn] => 2017-05-29 [checkout] => 2017-06-02 [roomNumber] => 2-Single-Bed 37usd [firstName] => [lastName] => [idType] => International Passport [idNumber] => [phoneNumber] => [address] => 123 [submit] => Update )

    $guestHotelId = $_POST["guestHotelId"];
    $checkin =  mysqli_real_escape_string($conn,$_POST["CheckIn"]);
     $checkin = formatDates($checkin);
    $checkout =  mysqli_real_escape_string($conn,$_POST["checkout"]);
     $checkout = formatDates($checkout);
    $room = mysqli_real_escape_string($conn,$_POST["roomNumber"]);
    $firstName =  mysqli_real_escape_string($conn,$_POST["firstName"]);
    $lastName =  mysqli_real_escape_string($conn,$_POST["lastName"]);
    $gender =  mysqli_real_escape_string($conn,$_POST["gender"]);
    $idType =  mysqli_real_escape_string($conn,$_POST["idType"]);
    $idNumber =  mysqli_real_escape_string($conn,$_POST["idNumber"]);
    $phoneNumber =  mysqli_real_escape_string($conn,$_POST["phoneNumber"]);
    $address =  mysqli_real_escape_string($conn,$_POST["address"]);

     //room number and room type
    $roomNumber = $room[0];

    $result = selectWhereLike("rooms","room_no",$roomNumber);
    $row = mysqli_fetch_assoc($result);
    $roomType = $row["room_type"];

    $query = "UPDATE occupied_rooms SET guest_hotel_id='{$guestHotelId}', first_name='{$firstName}', last_name='{$lastName}', gender='{$gender}', id_type='{$idType}', id_number='{$idNumber}', phone_number='{$phoneNumber}', Address='{$address}',check_in='{$checkin}', Check_out='{$checkout}',room_number={$roomNumber},room_type='{$roomType}'  WHERE guest_hotel_id='{$guestHotelId}'";


    $result = mysqli_query($conn,$query);

     if($result){
        //  echo $query;
        redirect("reservations.php?message=Saved&reservationOption=new");
     }else{
         echo $query;
        // redirect("reservations.php?message=Something+Went+wrong+Please+Contact+system+administrator&reservationOption=new");
     }

//       $_SESSION["availableDates"]="";

 }else{

redirect("reservations.php?message=Please+Enter+Required+Information&reservationOption=new&checkin={$_POST['CheckIn']}&checkout={$_POST['checkout']}&firstName={$_POST['firstName']}&lastName={$_POST['lastName']}&gender={$_POST['gender']}&idType={$_POST['idType']}&idNumber={$_POST['idNumber']}&phoneNumber={$_POST['phoneNumber']}&address={$_POST['address']}&roomNumber={$_POST['roomNumber']}");
   

  
}































}elseif($_POST["submit"]=="Add The Event"){
    
   if($_POST["date"] || $_POST["time"] || $_POST["action"] !=""){

   $date = mysqli_real_escape_string($conn,$_POST["date"]);
   $time = mysqli_real_escape_string($conn, $_POST["time"]);
   $action = mysqli_real_escape_string($conn,$_POST["action"]);

//check date less than today
if(strtotime($date)<=strtotime("yesterday")){
       redirect("todo.php?message=Wrong+Date&date={$date}&time={$time}&action={$action}");
   }
//convert date to ISO format
   $date = formatDates($date);

   $query = "INSERT INTO todo (datee,timee,action) VALUES ('{$date}','{$time}','{$action}')";

   $result = mysqli_query($conn,$query);

   if($result){
        redirect("todo.php?message=Saved");
   }else{
    //    echo $query;
        redirect("todo.php?message=Something+went+wrong.+Please+contact+the+system+administrator&date={$date}&time={$time}&action={$action}");
         
   }
   
   }else{
       redirect("todo.php?message=Please+Enter+all+the+Fields");
   }
    
//================================================================//
}elseif($_POST["submit"]=="Save Room"){
//er] => 51 [roomType] => Live Like a King [price] => 500 [details] => this is the best room in the hotel [submit] => Save Room )
if($_POST["roomNumber"]!="" && $_POST["roomType"]!="" && $_POST["price"]!="" && $_POST["roomNumber"]!=""){

$roomNo = $_POST["roomNumber"];
$roomType = mysqli_real_escape_string($conn,$_POST["roomType"]);
$price = mysqli_real_escape_string($conn,$_POST["price"]);
$details = mysqli_real_escape_string($conn,$_POST["details"]);

$query = "INSERT INTO rooms (room_no,room_type,price,details) VALUES ({$roomNo},'{$roomType}','{$price}','{$details}')";

$result = mysqli_query($conn,$query);

if($result ){
               redirect("administration.php?option=newRoom&message=Saved");
    }else{
        redirect("administration.php?option=newRoom&message=Something+Wrong+with+the+database+please+contact+the+system+administrator");
    }
}else{
    redirect("administration.php?option=newRoom&message=Please+insert+All+the+Fields");
}

}elseif($_POST["submit"]=="update Room"){
 //Array ( [roomNumber] => 1 [roomType] => Single-Bed [price] => 37 [details] => This is the room [submit] => update Room )
$roomNo = $_POST["roomNumber"];
$roomType = mysqli_real_escape_string($conn,$_POST["roomType"]);
$price = mysqli_real_escape_string($conn,$_POST["price"]);
$details = mysqli_real_escape_string($conn,$_POST["details"]);

    $query = "UPDATE rooms SET room_no={$roomNo}, room_type='{$roomType}', price='{$price}', details='{$details}' WHERE room_no={$roomNo}";

    $result = mysqli_query($conn,$query);

    if($result){
            redirect("administration.php?option=newRoom&message=Saved");
    }else{
        redirect("administration.php?option=newRoom&message=Something+Wrong+with+the+database+please+contact+the+system+administrator");
    }
    
}elseif($_POST["submit"]=="Update Event"){
    //y ( [date] => 2017-04-22 [time] => 22:22 [action] => mhgcfghdxgcfnhvbm [submit] => Update Event )
    if($_POST["date"] || $_POST["time"] || $_POST["action"] !=""){

   $date = mysqli_real_escape_string($conn,$_POST["date"]);
   $time = mysqli_real_escape_string($conn, $_POST["time"]);
   $action = mysqli_real_escape_string($conn,$_POST["action"]);
   $number =mysqli_real_escape_string($conn,$_POST["number"]);
//check date less than today
if(strtotime($date)<=strtotime("yesterday")){
       redirect("todo.php?message=Wrong+Date&date={$date}&time={$time}&action={$action}&btn=update");
   }
//convert date to ISO format
   $date = formatDates($date);

   $query = "UPDATE todo SET datee='{$date}', timee='{$time}', action='{$action}' WHERE no=".$number;

   $result = mysqli_query($conn,$query);

   if($result){
        redirect("todo.php?message=Saved");
   }else{
 echo $query;
                // redirect("todo.php?message=Something+went+wrong.+Please+contact+the+system+administrator&number={$number}&date={$date}&time={$time}&action={$action}&btn=update");
   }
    
}
}

//==============================================================================//

if($_GET["optionSpecial"]==="deleteuser"){

  $query = "DELETE FROM user WHERE username='".$_GET["username"]."' LIMIT 1";
    $result = mysqli_query($conn,$query);
    if($result){
        redirect("administration.php?option=viewUser&message=Deleted");
    }else{
        redirect("administration.php?option=viewUser&message=Something+went+Wrong+when+deleting+a+user");
    }

}elseif($_GET["optionSpecial"]==="deleteToDo"){

  $query = "DELETE FROM todo WHERE no='".$_GET["number"]."' LIMIT 1";
    $result = mysqli_query($conn,$query);
    if($result){
        redirect("todo.php?User&message=Deleted");
    }else{
        redirect("todo.php?message=Something+went+Wrong+when+deleting+a+user");
    }

}

?>
<?php if(isset($conn)){mysqli_close($conn);} ?>

