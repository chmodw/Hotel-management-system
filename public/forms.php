<?php include_once("../admin/functions.php"); ?>
<?php include_once("../admin/classes.php"); ?>
<?php


if($_POST["submit"]=="Available Rooms") {
    //array_diff () Differance//array_intersect()

    if ($_POST["CheckIn"] || $_POST["checkout"] == "") {

        if (strtotime($_POST["CheckIn"]) > strtotime($_POST["checkout"])) {
            // check check-in date is less than check-out
            redirect("reservations.php?message=Wrong+Date+Combination&reservationOption=new");

        } else {


            $availableDates = availableDates($_POST["CheckIn"], $_POST["checkout"]);

            $_SESSION["availableDates"] = $availableDates;

            redirect("reservations.php?checkin={$_POST["CheckIn"]}&checkout={$_POST["checkout"]}&reservationOption=new");

        }


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

        $query = "INSERT INTO online (guest_hotel_id,first_name,last_name,gender,id_type,id_number,phone_number,Address,check_in,Check_out,room_number,room_type) VALUES ('{$guestId}','{$firstName}','{$lastName}','{$gender}','{$idType}','{$idNumber}','{$phoneNumber}','{$address}','{$checkin}','{$checkout}','{$roomNumber}','{$roomType}')";

        $result = mysqli_query($conn,$query);

        if($result){
            redirect("reservations.php?message=Room+Reserved");
        }else{
            redirect("reservations.php?message=Something+Went+wrong+Please+Contact+system+administrator&reservationOption=new");
        }

        $_SESSION["availableDates"]="";

    }else{

        redirect("reservations.php?message=Please+Enter+Required+Information&reservationOption=new&checkin={$_POST['CheckIn']}&checkout={$_POST['checkout']}&firstName={$_POST['firstName']}&lastName={$_POST['lastName']}&gender={$_POST['gender']}&idType={$_POST['idType']}&idNumber={$_POST['idNumber']}&phoneNumber={$_POST['phoneNumber']}&address={$_POST['address']}&roomNumber={$_POST['roomNumber']}");



    }




}elseif($_POST["submit"]=="Send"){

  //Array ( [name] => [email] => [subject] => [message] => [submit] => Send )

    if($_POST["name"] && $_POST["email"] && $_POST["subject"] && $_POST["message"] != "") {

        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
        $message = mysqli_real_escape_string($conn, $_POST["message"]);

        $query = "INSERT INTO customer_messages (customerName,email,subject,message) VALUE ('{$name}','$email','$subject','$message')";

        $result = mysqli_query($conn,$query);

        if($result){
            redirect("about_us.php?message=Thank+You,+We+will+Response+you+soon");
        }else{
            redirect("about_us.php?message=Message+Not+Sent,+try+again+later");
        }

}else{
        redirect("about_us.php?message=Please+Enter+all+the+fields");
    }


}



?>