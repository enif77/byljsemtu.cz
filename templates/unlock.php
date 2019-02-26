<!DOCTYPE html>
<html>
<head>
    <title>Byl jsem tu! - Code Unlock</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/list.css">
    <style>
    </style>
</head>

<body>

<?php 

    //UI_Header("index.php"); 
    UI_BeginContent();

    $lock = DB_GetLock($db, URL_GetParameter("l", 0));
?>

    <h2>Code Unlock</h2>

    <form action="" method="post">
        <label>Code:</label>
        <input id="lockName" name="lockName" placeholder="lock name" value="<?php echo $lock["Name"]; ?>" type="text">
        <label>Password:</label>
        <input id="password" name="password" placeholder="**********" type="password">
        <input name="submit" type="submit" value="Unlock">
        <input id="target" name="target" type="hidden" value="<?php echo URL_GetParameter("t", "index.php"); ?>">

        <p><?php echo $error; ?></p>
    </form>

<?php 

    UI_EndContent(); 
    UI_Footer();

?>

</body>
</html>