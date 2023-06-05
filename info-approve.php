<?php
// стартуем сессию, чтобы через нее передавать ошибки в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./index.php");
}

// записываем в переменную id сделки, которую мы передали через ссылку
$id_approve = $_GET['id'];

// подключим БД
require_once("./db/db.php");

// отправим запрос в БД, на выборку сдели по ее id, которое мы записали в переменную,
// которую мы получили в свою очередь через ссылку
$select_approve = mysqli_query($link, "SELECT * FROM `approve` WHERE `id` = '$id_approve'");

// превратим ответ из БД в ассоциативный массив, чтобы можно было
// обращаться к отдельным полям таблицы, по их именам 
$select_approve = mysqli_fetch_assoc($select_approve);

// запишем id владельца, id здания и id квартиры в переменные 
$id_owner = $select_approve['id_owner'];
$id_const = $select_approve['id_const'];
$id_flat = $select_approve['id_flat'];

// отправим запрос в БД, на выборку квартиры по ее id, которое мы записали в переменную
$select_flat = mysqli_query($link, "SELECT * FROM `flat` WHERE `id` = '$id_flat'");

// превратим ответ из БД в ассоциативный массив, чтобы можно было
// обращаться к отдельным полям таблицы, по их именам 
$select_flat = mysqli_fetch_assoc($select_flat);

// отправим запрос в БД, на выборку здания по его id, которое мы записание в переменную 
$select_const = mysqli_query($link, "SELECT * FROM `construction` WHERE `id` = '$id_const'");

// превратим ответ из БД в ассоциативный массив, чтобы можно было
// обращаться к отдельным полям таблицы, по их именам 
$select_const = mysqli_fetch_assoc($select_const);

// отправим запрос в БД, на выборку владельца здания по его id, которое мы записали в переменную
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$id_owner'");

// превратим ответ из БД в ассоциативный массив, чтобы можно было
// обращаться к отдельным полям таблицы, по их именам 
$select_user = mysqli_fetch_assoc($select_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Выведем название квартиры -->
    <title>Квартира - <?= $select_flat['name']; ?></title>
</head>
<body>
    <a href="./home.php">Назад</a>
    <br>
    <div class="flat-info">
        <!-- Выведем название квартиры -->
        <h2><?= $select_flat['name']; ?></h2>

        <!-- Вывдем владельца здания -->
        <p>Владелец: <strong><?= $select_user['full_name']; ?></strong></p>

        <!-- Выведем квадратуру квартиры -->
        <p>Квадратура: <strong><?= $select_flat['square_meter']; ?> Кв.м.</strong></p>

        <!-- Выведем описание квартиры -->
        <p><?= $select_flat['descr']; ?></p>

        <!-- Выведем изображение квартиры -->
        <img src="<?= "./" . $select_flat['flat_img']; ?>">

        <!-- Выведем цену квартиры -->
        <p>Цена: <strong><?= $select_flat['price']; ?></strong></p>
    </div>
</body>
</html>