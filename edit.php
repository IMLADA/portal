<?php
    session_start();
    require("con_bd.php");
    $category = $_POST['category'];
    $id_post = $_POST['id'];
    $sql = "UPDATE task SET id_category='".$category."' WHERE
    id='".$id_post."' AND id_user='".$_SESSION["session"]."'";
    mysqli_query($mysqli, $sql);
    echo $sql;
?>