<?php
require_once "connection.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Checking if username is empty or not
    if(empty(trim($_POST["username"]))){
        $username_err = "Empty username";
    }
    else{
        $sql = "SELECT id FROM adminloginform WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of parameter username
            $param_username = trim($_POST['username']);

            // Try to execute the above statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "ERROR!!";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Checking the password
if(empty(trim($_POST['password']))){
    $password_err = "Please enter a valid password";
}
elseif(strlen(trim($_POST['password'])) < 8){
    $password_err = "Password must be of atleast 8 characters";
}
else{
    $password = trim($_POST['password']);
}

// Checking the confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords mismatch";
}


// inserting into the database if there were no errors 
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO adminloginform (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Setting the above parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Execution of the  above query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: adminlogin.php");
        }
        else{
            echo "Cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>
