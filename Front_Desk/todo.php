<?php include_once("../admin/functions.php"); ?>
<?php
    checkLog();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Front Desk | To Do</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
    <?php include_once("../admin/functions.php"); ?>
    <?php include_once("../admin/classes.php"); ?>
</head>
<body id="todo">
<header>
<?php include("header.php"); ?>
</header>
<aside id="left">
<h1>Add an Event</h1>
<form method="POST" action="forms.php" >
<input type="hidden" name="number" value=<?php echo '"'.getCheck("number","number","").'"'; ?>>
<br>
Date : <input type="Date" name="date" placeholder="YYYY-MM-DD"  value=<?php echo '"'.getCheck("date","date","").'"'; ?>/>
<br/>
Time : <input type="time" name="time" placeholder="HH:MM" value=<?php echo '"'.getCheck("time","time","").'"'; ?>/>
<br/>
<textarea name="action" placeholder="Action" > <?php echo getCheck("action","action",""); ?> </textarea>
<br/>
<?php if(isset($_GET["message"])){

            echo $_GET["message"];
} ?>
<input type="submit" name="submit" value=<?php if(isset($_GET["btn"])){echo '"'.'Update Event'.'"';}else{echo '"'.'Add The Event'.'"';}?>/>
</form> 
</aside>
<article>
    <table>
        <tr>
            <th id="action">Action</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
            <?php $todo = new toDo(); $todo->loadToDoTable(); ?>
    </table>
</article>
<footer>
    
    <?php include("footer.php"); ?>
</footer>
</body>
</html>

