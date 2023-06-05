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

// id пользователя возьмем из кук и запишем в переменную
$id_user = $_COOKIE['id_user'];

// данные из формы, мы запишем в пеменные
$name = $_POST['name'];
$geoposition = $_POST['geoposition'];
$free = 0;

// запишем чистый путь до файла, который будет отправлен в папку
$path = "upload/construction/" . time() . $_FILES['const_img']['name'];

// перенесем картинку из буфера сервера, в нужную папку
move_uploaded_file($_FILES['const_img']['tmp_name'], "../" . $path);

// отправим запрос в БД, на вставку данных из формы в таблицу
mysqli_query($link, "INSERT INTO `construction`
                    (`id_user`, `name`, `geoposition`, `const_img`, `free`) 
                    VALUES 
                    ('$id_user','$name','$geoposition','$path','$free')
");

// отправим пользователя на прошлую страницу (страницу, с которой пришел запрос)
header("Location: " . $_SERVER['HTTP_REFERER']);
?>