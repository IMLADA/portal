<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        #inner {
            padding: 10px;
            margin: 10px;
            display: flex;
            width: 800px;
            background-color: pink;
        }
        #outer {
            padding: 10px;
            margin: 10px;
            display: flex;
            flex-direction: column;
            background-color: gray;
        }
        body {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    
    <div >
    <?php
        session_start();
        if (!$_SESSION['session']) {
            header('Location: /');
        }
        if ($_POST["id"]) {
            $id = $_POST['id'];
            echo $id;
            require("con_bd.php");
            $sql = "DELETE FROM task WHERE id = '".$id."'";
            mysqli_query($mysqli, $sql);
            echo "Удалено";
        }


        require("con_bd.php");
        $sql = "SELECT DISTINCT * FROM task
        INNER JOIN users on users.id = task.id_user
        INNER JOIN status on status.id = task.id_status
        INNER JOIN category on category.id = task.id_category
        WHERE task.id_user='".$_SESSION["session"]."'";
        $response = mysqli_query($mysqli, $sql);
        $dates = mysqli_fetch_all($response);
        foreach ($dates as $key) {
            $counter = 0;
            /* foreach ($key as $value) {
                echo $counter."=".$value." ";
                $counter++;
            } */
            
            echo "<div id='outer'>";
            echo '<form id="form1" method="POST" action="" onsubmit="return confirm(`Удалить?`)">
            <input type="number" name="id" value='.$key[0].' style = "display:none">
            <input type="submit" value="Удалить">
        </form>';
            echo "<div id='inner'>";
            echo "Название заявки: ".$key[3]."<br>";
            echo "Описание заявки: ".$key[4]."<br>";
          
            echo '<form id="form1" method="POST" action="edit.php" onsubmit="return confirm(`Удалить?`)">
            <input type="number" name="id" value='.$key[0].' style = "display:none">
            
        ';
            echo      ' Категория заявки: <input list="list" name="category" autocomplete="off" value="'.$key[16].'"><br>
                <datalist id="list">';
                    require("con_bd.php");
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($mysqli, $sql);
                    $dates1 = mysqli_fetch_all($result);
                    foreach ($dates1 as $key2) {
                        echo "<option value='".$key2[0]."'>$key2[1]</option>";
                    }
        echo'</datalist><input type="submit" value="Сменить категорию">';
        echo '</form>';
            echo "Статус заявки: ".$key[18]."<br>";
            echo "Временная метка: ".$key[6]."<br>";
            echo "<img src='".$key[5]."' width='100px'>";
            echo "</div><hr></div></div>";
        }

    ?>

    </div>
</body>
</html>