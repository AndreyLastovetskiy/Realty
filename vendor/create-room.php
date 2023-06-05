<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
// или если его id_group не равно 2, то мы не даем ему доступа к контенту станицы
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../index.php");
} elseif($_COOKIE['id_group'] != 2) {
    header("Location: ../home.php");
}

// подключим БД
require_once("../db/db.php");

// данные из формы запишем в переменные 
$id_const = $_POST['id_const'];
$name = $_POST['name'];
$descrip = $_POST['descrip'];
$square_meter = $_POST['square_meter'];
$price = $_POST['price'];

// запишем чистый путь до файла, который будет отправлен в папку
$path = "upload/flat/" . time() . $_FILES['flat_img']['name'];

// перенесем картинку из буфера сервера, в нужную папку
move_uploaded_file($_FILES['flat_img']['tmp_name'], "../" . $path);

// отправим запрос в БД, на вставку данных в таблицу
mysqli_query($link, "INSERT INTO `flat`
                    (`id_const`, `name`, `descr`, `square_meter`, `price`, `flat_img`) 
                    VALUES 
                    ('$id_const','$name','$descrip','$square_meter','$price','$path')
");

// перенаправим пользователя на страницу здания, по его id
header("Location: ../construction.php?id=" . $id_const);