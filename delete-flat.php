<?php
// сделаем проверку на пользователя, если id_group в куках, равно 2,
// тогда мы разрешим дальше выполняться коду (ДЛЯ ВЛАДЕЛЬЦА ЗДАНИЙ)
if($_COOKIE['id_group'] != 2) {
    header("Location: ./home.php");
}

// подключим БД
require_once("./db/db.php");

// в переменную запишем id квартиры, которые мы передали через ссылку
$id_flat = $_GET['id'];

// отправим запрос в БД, на выборку конкретной кварты,
// по ее id, которое мы записали в переменную
$select_flat = mysqli_query($link, "SELECT * FROM `flat` WHERE `id` = '$id_flat'");

// превратим ответ из БД в ассоциативный массив,
// чтобы можно было обращаться к отдельным ее полям, по их именам 
$select_flat = mysqli_fetch_assoc($select_flat);

// отправим запрос на удаление квартиры, которое мы передали через ссылку
mysqli_query($link, "DELETE FROM `flat` WHERE `id` = '$id_flat'");

// перенаправим на страницу здания, к которому относится данная квартира
header("Location: ./construction.php?id=" . $select_flat['id_const']);
?>