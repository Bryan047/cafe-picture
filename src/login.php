<?php
session_start();
include "conn.php";


if (isset($_POST['uname']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: loginForm.php?error=User Name is requited");
        exit();
    }else if(empty($pass)){
        header("Location: loginForm.php?error=Password is requited");
        exit();
    }else{

        $pass = md5($pass);

        $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password'] === $pass ) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
                $_SESSION['password'] = $row['password'];
            	header("Location: main2.php");
		        exit();
            }else{
				header("Location: loginForm.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: loginForm.php?error=Incorect User name or password");
	        exit();
		}
    }

}else{
    header("Location: loginForm.php");
    exit();
}

?>