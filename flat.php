<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./index.php");
}

// запишем в переменную id квартиры, которое мы передали через ссылку
$id_flat = $_GET['id'];

// подключим БД
require_once("./db/db.php");

// отправим запрос в БД, на выборку конкретной квартиры,
// по ее id, которое мы записали в переменную
$select_flat = mysqli_query($link, "SELECT * FROM `flat` WHERE `id` = '$id_flat'");

// превратим ответ из БД, в ассоциативный массив, чтобы можно было 
// обращаться к отдельным полям таблицы, по их именам
$select_flat = mysqli_fetch_assoc($select_flat);

// запишем в переменную id здания
$select_flat_idconst = $select_flat['id_const'];

// отправим запрос в БД, на выборку конкретного здания,
// по его id, которое мы записали в переменную
$select_const = mysqli_query($link, "SELECT * FROM `construction` WHERE `id` = '$select_flat_idconst'");

// превратим ответ из БД, в ассоциативный массив, чтобы можно было 
// обращаться к отдельным полям таблицы, по их именам
$select_const = mysqli_fetch_assoc($select_const);

// запишем в переменную id клиента
$select_const_iduser = $select_const['id_user'];

// отправим запрос в БД, на выборку конкретного клиента,
// по его id, которое мы записали в переменную
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$select_const_iduser'");

// превратим ответ из БД, в ассоциативный массив, чтобы можно было 
// обращаться к отдельным полям таблицы, по их именам
$select_user = mysqli_fetch_assoc($select_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Квартира - <?= $select_flat['name']; ?></title>
</head>
<body>
    <a href="./home.php">Назад</a>
    <br>
    <?php
    // сделаем проверку на пользователя, если id_group в куках, равно 2,
    // тогда мы выведем данную форму (ДЛЯ ВЛАДЕЛЬЦА ЗДАНИЙ)
    if($_COOKIE['id_group'] == 2) { ?>
        <a href="./delete-flat.php?id=<?= $id_flat; ?>">Удалить квартиру</a>
    <?php } ?>
    <div class="flat-info">
        <h2><?= $select_flat['name']; ?></h2>
        <p>Хозяин: <strong><?= $select_user['full_name']; ?></strong></p>
        <p>Квадратура: <strong><?= $select_flat['square_meter']; ?> Кв.м.</strong></p>
        <p><?= $select_flat['descr']; ?></p>
        <img src="<?= "./" . $select_flat['flat_img']; ?>">
        <p>Цена: <strong><?= $select_flat['price']; ?></strong></p>
        <a href="./approve.php?id=<?= $id_flat; ?>">Согласовать сделку</a>
    </div>
</body>
</html>