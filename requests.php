<?php
    
    require("./con_bd.php");
    function Check_user() {
        //Функция проверки юзера в БД
        //подключились к базам данных
        require("./con_bd.php");
        //сформировали запрос
        $sql = "SELECT login FROM users WHERE
        login = '".$login."' ";
        //сохраняем ответ БД в response переменную
        $response = mysqli_query($mysqli, $sql);
        //преобразуем ответ в удобный формат
        $dates = mysqli_fetch_assoc($response);
        if (isset($dates)) {
            //если логин уже занят
            return true;
        } else {
            //если логина еще не существует
            return false;
        }
    }
    //данные пользователя
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $secondname = $data['secondname'];
    $login = $data['login'];
    $password = $data['password'];
    $email = $data['email'];
    function CheckName($login1) {
        return preg_match("/^[a-zA-Z]+$/", $login1);
    }
    $checked = Check_user();
    if ($checked == false && CheckName($login) == true) {
        //регистрируем пользователя
        $sql = "INSERT INTO users (firstname, lastname,
                                   secondname, login,
                                   password, email)
        VALUES ('$firstname', '$lastname', '$secondname',
                '$login', '$password', '$email')";
        /* ВСТАВИТЬ В {имя таблицы (поле1,..,полеХ)}
        ЗНАЧЕНИЯ {переменная1,..,переменнаяХ}*/
        if (mysqli_query($mysqli, $sql)) {
            /*Если выполнение запроса произошло успешно,
            то уведомить об успехе добавления нового польз-я
            mysqli_query функция для выполенния запросов к БД*/
            echo json_encode($data);
        } else {
            //иначе печатаем ошибку по нашему запросу
            $error = ['status'=>"Error: " . $sql . "<br>".mysqli_error($mysqli)];
            echo json_encode($error);
            
        }
        mysqli_close($mysqli); //закрываем соедение с БД
    } else {
        echo json_encode(["status"=>"Не уникально"]);
        //не зареган
    }
?>