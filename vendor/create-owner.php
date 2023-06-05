<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
// или если его id_group не равно 1, то мы не даем ему доступа к контенту станицы
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../index.php");
} elseif($_COOKIE['id_group'] != 1) {
    header("Location: ../home.php");
}

// подключим БД
require_once("../db/db.php");

// данные из формы, мы запишем в пеменные
$idgroup = 2;
$login = $_POST['login'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$full_name = $_POST['full_name'];

// отправим запрос в БД, на выборку пользователя, где логин в таблице,
// совпадает с логином из формы
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");

// превратим ответ из БД, в ассоциативный массив, чтобы можно было обращаться,
// к отдельным полям таблицы, по их именам
$select_user = mysqli_fetch_assoc($select_user);

// структура проверки
// если не найден пользователь с логином, который мы отправили из формы,
// то проверяем на совпадение, пароли
// если пароли совпали, хэшируем пароли отправляем запрос в БД, на вствку данных в таблицу,
// а затем перенаправляем на домашнюю страницу,
// иначе, выдаем ошибку, что такой пользователь уже существует
if(empty($select_user)) {
    if($password != $cpassword) {
        $_SESSION['errOwn'] = "Пароли не совпадают!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($link, "INSERT INTO `user`
                            (`idgroup`, `login`, `password`, `email`, `phone`, `full_name`)
                            VALUES 
                            ('$idgroup','$login','$pass_hash','$email','$phone','$full_name')
        ");
        header("Location: ../home.php");
    }
} else {
    $_SESSION['errOwn'] = "Такой пользователь уже существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>