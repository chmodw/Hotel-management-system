<?php include_once("dbConnection.php");?>
<?php session_start(); ?>


<?php

    function redirect($url){
    header("Location: ".$url);
} 
    function isEmpty($data){
        if (isset($data)){
        $dta2 = trim($data);
        return $dta2 !=="";
        }else{
            return false;
        }
    }

    function selectAll($tableName){

        global $conn;
        $query = "SELECT * FROM ".$tableName;
        if($result = mysqli_query($conn, $query)){
        return ($result);
        }else{
            return "";
            }
    }

    function selectWhereLike($tableName,$columnName,$data){

        global $conn;
        $query = "SELECT * FROM {$tableName} WHERE {$columnName} = "."'".$data."'";
        $result = mysqli_query($conn, $query) or die(mysqli_error());

        return ($result);
    }

    function getCheck($index,$index2,$else){

        //index = checking value
        //index2 = if true return this data
        //else = if it is not return this 

        if(isset($_GET["{$index}"])){
            $return = $_GET["{$index2}"];
        }else{
            $return = $else;
        }

        return ($return);
    }

    function checkLog(){
    if(!isset($_SESSION["login"])){
        redirect("index.php?message=Please+Log+in+using+Valid+username+and+password");
    }

    }

    function betweenDays($startDate,$endDate){

    $forFuture = $startDate;
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $days = ($endDate-$startDate)/86400;
    for($x=0;$days>$x;$x++){
        
        $startDate+=86400;
    
        $dateArray[$x]= Date("Y-m-d",$startDate);
    }

    array_unshift($dateArray,$forFuture);
    
    return ($dateArray);

    }

    function availableDates($checkin,$checkout){

        $checkin = formatDates($checkin);
        $checkout = formatDates($checkout);

        $availableRooms = array();

        $status = new status();
        //get total room count
        $totalRooms = $status->totalRoomCount();

        //this array contains between dates from new reservation form
        $outSideArray = betweenDays($checkin,$checkout);

        //check occupied rooms table for room number and get check in and checkout dates using for loop
        for($x=1;$totalRooms>=$x;$x++){
            $result = selectWhereLike("occupied_rooms","room_number",$x);
            $row = mysqli_fetch_assoc($result);

            if($row){
                //this array contains between dates in occupied room
                $insideArray = betweenDays(formatDates($row["check_in"]),formatDates($row["Check_out"]));

                if((array_intersect($insideArray,$outSideArray))){

                }else{
                    $availableRooms[] = $x;
                }

            }else{
                //if room no not found in the occupied room that means it is a free room
                $availableRooms[] = $x;
            }

        }
        return ($availableRooms);

}
    function  formatDates($date){

        $date = strtotime($date);
        $date =date("Y-m-d",$date);
        return $date;

    }

    function deleteRecord($tableName,$columnName,$data){
        global $conn;
        $query = "DELETE FROM {$tableName} WHERE {$columnName}='".$data."' LIMIT 1";
        $result = mysqli_query($conn,$query);
        if($result){
            return true;
        }else{
            return false;
        }
    }


    
  ?>
