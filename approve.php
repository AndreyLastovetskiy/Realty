<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./index.php");
}

// запишем в переменную id, квартиры, которое мы передали через ссылку
$id_flat = $_GET['id'];

// подключим БД
require_once("./db/db.php");

// отправим запрос в БД, на выборку конкретной квартиры,
// по id, которое мы записали в переменную
$select_flat = mysqli_query($link, "SELECT * FROM `flat` WHERE `id` = '$id_flat'");

// превратим ответ из БД, в ассоциативный массив,
// чтобы можно было обращаться к отдельным полям таблицы, по их именам
$select_flat = mysqli_fetch_assoc($select_flat);

// запишем в перменную id здания, к которому относится данная квартира
$select_flat_idconst = $select_flat['id_const'];

// отправим запрос в БД, на выборку здания, по его id
// которое мы записали в переменную
$select_const = mysqli_query($link, "SELECT * FROM `construction` WHERE `id` = '$select_flat_idconst'");

// превратим ответ из БД, в ассоциативный массив,
// чтобы можно было обращаться к отдельным полям таблицы, по их именам
$select_const = mysqli_fetch_assoc($select_const);

// запишем в переменную id владельца здания
$select_const_iduser = $select_const['id_user'];

// отправим запрос в БД, на выборку владельца здания, 
// по его id, которое мы записали в перменную 
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$select_const_iduser'");

// превратим ответ из БД, в ассоциативный массив,
// чтобы можно было обращаться к отдельным полям таблицы, по их именам
$select_user = mysqli_fetch_assoc($select_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Согласовать сделку</title>
</head>
<body>
    <h2>Согласование сделки на покупку квартиры - <?= $select_flat['name']; ?></h2>
    <form action="./vendor/approve.php?id=<?= $id_flat; ?>" method="post">
        <input type="hidden" name="id_owner" value="<?= $select_user['id']; ?>">
        <input type="hidden" name="id_client" value="<?= $_COOKIE['id_user']; ?>">
        <input type="hidden" name="id_const" value="<?= $select_const['id']; ?>">
        <input type="hidden" name="id_flat" value="<?= $id_flat; ?>">
        <button>Согласовать</button>
    </form>
</body>
</html>