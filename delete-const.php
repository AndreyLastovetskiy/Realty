<?php
// сделаем проверку на пользователя, если id_group в куках, равно 2,
// тогда мы разрешим дальше выполняться коду (ДЛЯ ВЛАДЕЛЬЦА ЗДАНИЙ)
if($_COOKIE['id_group'] != 2) {
    header("Location: ./home.php");
}

// подключим БД
require_once("./db/db.php");

// в переменную запишем id здания, которое мы передали через ссылку
$id_const = $_GET['id'];

// отправим запрос на удалене здания по его id, которое мы записали в переменную
mysqli_query($link, "DELETE FROM `construction` WHERE `id` = '$id_const'");

// отпаврим запрос на удаление квартир по id здания, к которым относятся квартиры 
mysqli_query($link, "DELETE FROM `flat` WHERE `id_const` = '$id_const'");

// перенаправим на домашнюю страницу
header("Location: ./home.php");
?>