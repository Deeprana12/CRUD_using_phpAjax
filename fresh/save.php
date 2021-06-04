<?php
	require_once 'connect.php';	
    //&& $_POST['last_name'] && $_POST['hobbies'] && $_POST['age'] && $_POST['state'] && $_POST['ph_no']
    if(isset($_POST['first_name'])){
        $fname=$_POST['first_name'];
        $lname=$_POST['last_name'];
        $hobbies=$_POST['hobbies'];
        $age=$_POST['age'];
        $state=$_POST['state'];
        $ph_no=$_POST['ph_no'];
        // $b=implode(",",$hobbies);
    
        $sql = "INSERT INTO `temp`( `first_name`, `last_name`,`hobbies`,`ph_no`,`age`,`state`) 
        VALUES ('$fname','$lname','$hobbies','$ph_no','$age','$state')";
        $statement = $conn->prepare($sql);
        $statement->execute();
        header('location:index.php');
        header('location:action.php');
    }
?>
 