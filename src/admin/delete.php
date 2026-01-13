<?php
    include "../func/database.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        delete($id);
        echo "<script>
            alert('Xóa thành công');
            window.location.href='users.php';
        </script>";
    } else {
        echo "<script>
        alert('Xóa failed');
        window.location.href='users.php';
      </script>";
    }
?>