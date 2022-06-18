<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
        $conn = db();
   //check if user with this email already exist in the database
        $query = "SELECT * FROM students WHERE email = '$email'";
        $sql = mysqli_query($conn, $query);
   if(mysqli_num_rows($sql)){ 
       die('User already exist!');
    } else{ 
        $query = "INSERT INTO students (full_names, country, email, gender, password) VALUES ('$fullnames', '$country', '$email', '$gender', '$password')";
        $sql = mysqli_query($conn, $query);
   if($sql){
        echo "<script> alert('User Successfully Registered!') </script>";
        header('Location: ../forms/login.html');
    }
    }
}

//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
        $conn = db();
        echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
        $query = "SELECT full_names FROM students WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $rows = mysqli_num_rows($result);
    if($rows==1){
        $sql=mysqli_fetch_assoc($result);
        //if true then set user session for the user and redirect to the dasbboard
        session_start();
        $_SESSION['username']=$sql['full_names'];
        header('Location: ../dashboard.php');
   }
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
    $query = "SELECT id FROM students WHERE `email` = '$email'";
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $rows = mysqli_num_rows($result);
    if($rows==1){
        mysqli_query($conn, "UPDATE students SET `password`='$password' WHERE `email`='$email'");
        header('Location: ../forms/login.html');
   }
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    echo"<html><head></head><body><center><h1><u> ZURI PHP STUDENTS </u> </h1><table border='1' style='width: 700px; background-color: magenta; border-style: none'; ><tr style='height: 40px'><th>ID</th><th>FullNames</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";

    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     mysqli_query($conn, "DELETE FROM students WHERE `id`='$id'");
     header('Location: ./action.php?all');
 }
