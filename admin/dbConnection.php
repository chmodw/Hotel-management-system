    <?php
    //date_default_timezone_set("Asia/Colombo");
    define("DB_SERVER","localhost");
    define("DB_USER","root");
    define("DB_PASS","");
    define("DB_NAME","hotelmanagementsystem-new");
    $conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

    if(mysqli_connect_errno()){
        die("Database Connection failed!");
    }
    ?>
