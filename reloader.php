<?php
    //подключение к базам данных
    require("./con_bd.php");
    //формируем SQL-запрос к БД
    $sql = "SELECT COUNT(id_status) FROM task";
    //Выполняем запрос к БД и сохраняем ответ
    $result = mysqli_query($mysqli, $sql);
    //Преобразуем ответ в формат удобный
    $dates = mysqli_fetch_row($result);
    /* КОМАНДА my_sqli_fetch_assoc
    преобразует ответ сервера баз данных
    в массив, с которым удобно работать */
    echo json_encode(['status'=>$dates[0]]);
?>