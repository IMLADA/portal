<?php
session_start();
function Photo_upload() {
    $id_user = $_SESSION["session"];
    $id_category = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $id_status = 1;
    $date = date("Y-m-d H:i:s", time());

    echo $id_category." ".$title." ".$description." ".$date;
    //в name лежит путь к папке с картинками нашего сервера
    $name = "img/".$_FILES["photo"]["name"];

    
    /*move_uploaded_file перемещает загруженную картинку пользователя по
    нашему пути, указанном в перменной name; $_FILES["photo"]["tmp_name"] 
    хранит загруженную картинку пользователя во временном хранилищи
    сервера move_uploaded_file(временный путь картинки, наш путь картинки)*/
    move_uploaded_file($_FILES["photo"]["tmp_name"], $name);

    echo "Фото:".$_FILES["photo"]["name"]."<br>";
    echo "Путь загруженного фото:".$_FILES["photo"]["tmp_name"]."<br>";
    echo "Новый путь для фотки:".$name."<br>";
    
    require("con_bd.php");
    $sql = "INSERT INTO task (id_user, id_category, name,
                            description, link_photo, date, id_status)
    VALUES ('$id_user', '$id_category', '$title', 
            '$description', '$name', 
            '$date', '$id_status')";
    if (mysqli_query($mysqli, $sql)) {
        /*Если выполнение запроса произошло успешно,
        то уведомить об успехе добавления нового польз-я
        mysqli_query функция для выполенния запросов к БД*/
        echo json_encode(["status" =>"Фото успешно загружено"], JSON_UNESCAPED_UNICODE);
    } else {
        //иначе печатаем ошибку по нашему запросу
        $error = ['status'=>"Error: " . $sql . "<br>".mysqli_error($mysqli)];
        echo json_encode(["status" =>"Фото успешно не загружено"], JSON_UNESCAPED_UNICODE);
        
    }
    mysqli_close($mysqli); //закрываем соедение с БД
}

if ($_POST["submit"] && $_FILES && $_FILES["photo"]["error"]== UPLOAD_ERR_OK)
{
    // ограничение размера файла
    $limit_size = 10*1024*1024; // 1 Mb
    // корректные форматы файлов
    $valid_format = array("jpeg", "jpg", "bmp", "png");
    // валидация размера файла
    if($_FILES["photo"]["size"] > $limit_size){
        echo json_encode(["status" =>"File size, more 10 MB!"]);
    } else {
        // валидация формата файла
        $format = end(explode(".", $_FILES["photo"]["name"]));
        if(!in_array($format, $valid_format)){
            echo json_encode(["status" =>"Format file not correct"]);
        } else {
            Photo_upload();
        }
    }

    
}
?>