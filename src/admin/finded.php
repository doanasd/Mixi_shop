<?php
    if (isset($_POST['finded'])) {
        include "../func/database.php";
        $name = $_POST['finded'];
        $rs = find($name);
        if($rs->num_rows>0){
            switch ($name) {
                case 'trang chu':
                    header("Location: ../index.php");
                    break;
                case 'gioi thieu':
                    header("Location: ../gioithieu.php");
                    break;
                case 'menu':
                    header("Location: ../menu.php");
                    break;
                case 'tin tuc':
                    header("Location: ../menu.php");
                    break;
                case 'lien he':
                    header("Location: ../lienhe.php");
                    break;
                default:
                    echo "<script>alert('Không tìm thấy')</script>";
                    break;
            }
        }
    }
?>