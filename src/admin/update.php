<?php
    session_start();
    if(isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['location']) && isset($_POST['fullname'])){
        require_once "../func/database.php";
        $name = $_SESSION['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $location = $_POST['location']; 
        $fullname = $_POST['fullname'];
        updateProfile($name,$phone,$email,$location,$fullname);
        echo "<script>
            alert('Cập nhật thành công');
            window.location.href='../profile.php';
        </script>";
    } else {
        echo "<script>
        alert('Cập nhật failed');
        window.location.href='../profile.php';
      </script>";
    }

?>