<?php
    session_start();
    function Get_user() {
        //подключение к базам данных
        require("./con_bd.php");
        //формируем SQL-запрос к БД
        $sql = "SELECT * FROM users WHERE
        id = '".$_SESSION['session']."'";
        //Выполняем запрос к БД и сохраняем ответ
        $result = mysqli_query($mysqli, $sql);
        //Преобразуем ответ в формат удобный
        $dates = mysqli_fetch_assoc($result);
        /* КОМАНДА my_sqli_fetch_assoc
        преобразует ответ сервера баз данных
        в массив, с которым удобно работать */
        if (isset($dates)) {
            foreach ($dates as $value) { 
                /*проходимся по каждому индексу в
                массиве dates в качестве переменной
                value*/
                echo $value." ";
            }
        } else {
            echo " Пользоватей не найдено ";
        }
    }
    function Get_Tasks() {
        //подключение к базам данных
        require("./con_bd.php");
        //формируем SQL-запрос к БД
        //Выполняем запрос к БД и сохраняем ответ
        $sql = "SELECT DISTINCT * FROM task
        INNER JOIN users on users.id = task.id_user
        INNER JOIN status on status.id = task.id_status
        INNER JOIN category on category.id = task.id_category
        ORDER BY date DESC LIMIT 4";
        //Преобразуем ответ в формат удобный
        $result = mysqli_query($mysqli, $sql);
        //Преобразуем ответ в формат удобный
        $dates = mysqli_fetch_all($result);
        /* КОМАНДА my_sqli_fetch_assoc
        преобразует ответ сервера баз данных
        в массив, с которым удобно работать */
        if (isset($dates)) {
            foreach ($dates as $key) {
                $counter = 0;
                /* foreach ($key as $value) {
                    echo $counter."=".$value." ";
                    $counter++;
                } */
                
                echo "<div id='outer'>";
                echo "<div id='inner'>";
                echo "Название заявки: ".$key[3]."<br>";
                echo "Описание заявки: ".$key[4]."<br>";
                echo "Категория заявки: ".$key[16]."<br>";
                echo "Статус заявки: ".$key[18]."<br>";
                echo "Временная метка: ".$key[6]."<br>";
                echo "<img src='".$key[5]."' width='60%'>";
                echo "</div></div><hr>";
            }
        } else {
            echo " Пользоватей не найдено ";
        }
    }
?>