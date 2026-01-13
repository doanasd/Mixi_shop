<?php
include "connect.php";
function profile($name)
{
    global $conn;
    $sql = "SELECT * from users where username = '$name'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    return $row;
}
function upload($name,$file){
    global $conn;
    $sql = "UPDATE users SET avatars = '$file' WHERE username = '$name'";
    $conn->query($sql);
}
function updateProfile($name,$phone,$email,$location,$fullname){
    global $conn;
    $sql = "UPDATE users SET phone = '$phone', email = '$email', location = '$location', fullname = '$fullname' WHERE username = '$name'";
    $conn->query($sql);
}
function users(){
    global $conn;
    $sql = "SELECT * from users where role = 'user'";
    $rs = $conn->query($sql);
    return $rs;
}
function delete($id){
    global $conn;
    $sql = "DELETE FROM users WHERE id = $id";
    $conn->query($sql);
}
function find($name){
    global $conn;
    $sql = "SELECT * from pages where name = '$name'";
    $rs = $conn->query($sql);
    return $rs;
}
