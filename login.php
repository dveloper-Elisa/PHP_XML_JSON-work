<?php
session_start();


include_once "connection.php";

$dbconnetion = new Database();
$db = $dbconnetion->getConnection();


if(!$db){
    die(json_encode(["error"=>"Database connection failure"]));
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>

<form method="post">

    <p>
        <input type="text" name="uname" placeholder="Enter User Name">
    </p>
    <p>
        <input type="password" name="password" placeholder="Enter Password">
    </p>

    <p>
        <input type="submit" value="Login" name="send">
    </p>

</form>
    
</body>
</html>

<!-- PHP LOGIN CODES -->

<?php

if(isset($_POST['send'])){

    $name = $_POST['uname'];
    $pass = $_POST['password'];


    if(empty($name) || empty($pass)){
        echo "Fill all fields";
    }else{

        $sql = "SELECT * FROM students WHERE name = ? AND email = ? ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $pass, PDO::PARAM_STR);

        $stmt -> execute();

        $result = $stmt -> fetch(PDO::FETCH_ASSOC);



        if($result){
            echo "$name  $pass";

            $_SESSION['username'] = $name;
            $_SESSION['loggedin'] = true;

            header("Location: index.php");
            exit();
        }else{
            echo "Invalid username or password";
        }
    }

}

?>