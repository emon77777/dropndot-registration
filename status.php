<?php
    include 'database/config.php';
    include 'database/database.php';
    
        if(isset($_GET['action'])){
            if(function_exists($_GET['action'])) {    
                $_GET['action']($_GET['email']);
            }
        }

        function changeStatus($email)
        {
            $db = new Database();
            $getEmail = "UPDATE users SET status=1 WHERE email='$email'";
            $result = $db->update($getEmail);
            header("Location:login.php");
        }