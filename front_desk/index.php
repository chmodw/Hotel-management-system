<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Front Desk | Login</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
    <?php include_once("../admin/classes.php"); ?>
</head>
<body id="login">
<header>
    <p>near Beach Hotel</p>
</header>
<article>
    <div>
    <form method="POST" action="forms.php" id="loginForm">
        <label>Username</label><br/><input type="text" name="username" placeholder="Username" maxlength="10"><br/>
        <label>Password</label><br/><input type="password" name="password" placeholder="Password" maxlength="16"><br/>
        <input type="submit" name="submit" value="Login">
        <br />
        <?php if(isset($_GET["message"])){echo '<p id="message">'.$_GET["message"]; $_GET["message"]=""."</p>";}else echo ""; ?>
    </form>
    </div>
</article>
</body>
</html>