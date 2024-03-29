<?php 
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){


    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['pass']);
    $cpass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM 'admins' WHERE name = ? AND password = ? ");
    $select_admin->execute([$name, $pass]);
    

    if($select_admin->rowCount() > 0 ){
       $message[] = 'username already exist!';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
        }else{
            $insert_admin = $conn->prepare("INSEERT INTO `admin`(name, password)VALUES(?,?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'new admin registered!';  
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/
    E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==">


    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'?>

<!-- register admin section starts -->

<section class="form-container">
    <form action="" method="POST">
        <h3>register new </h3>

        <input type="text" name="name" maxlength="20" required
        placeholder="enter your username" class="box" oninput="this.value = 
        this.value.replace(/\s/g, '')">

        <input type="password" name="pass" maxlength="20" required
        placeholder="enter your password" class="box" oninput="this.value = 
        this.value.replace(/\s/g, '')">

        <input type="password" name="pass" maxlength="20" required
        placeholder="confirm your password" class="box" oninput="this.value = 
        this.value.replace(/\s/g, '')">
        <input type="submit" value="register now"  name="submit" class="btn">
    </form>



<!-- register admin section ends -->