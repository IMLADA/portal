<?php
    session_start();
    if (!$_SESSION['session']) {
        header('Location: /');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data" action="create.php">
        <label>Название:</label>
        <input type="text" name="title"><br>
        <label>Описание:</label>
        <input type="text-area" name="description"><br>
        <label>Категория:</label>
        <input list="list" name="category" autocomplete="off"><br>
        <datalist id='list'>
        <?php 
            require("con_bd.php");
            $sql = "SELECT * FROM category";
            $result = mysqli_query($mysqli, $sql);
            $dates = mysqli_fetch_all($result);
            foreach ($dates as $key) {
                echo "<option value='".$key[0]."'>$key[1]</option>";
            }
        ?>
        </datalist>
        <label>Фото:</label>
        <input type="file" name="photo" multiple>
        <input type="submit" name="submit">
    </form>
</body>
</html>

