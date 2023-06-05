<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// подключим БД
require_once("../db/db.php");

// запишем данные из формы в переменные
$idgroup = 3;
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
// а затем перенаправляем на страницу авторизации,
// иначе, выдаем ошибку, что такой пользователь уже существует
if(empty($select_user)) {
    if($password != $cpassword) {
        $_SESSION['errReg'] = "Пароли не совпадают!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($link, "INSERT INTO `user`
                            (`idgroup`, `login`, `password`, `email`, `phone`, `full_name`)
                            VALUES 
                            ('$idgroup','$login','$pass_hash','$email','$phone','$full_name')
        ");
        header("Location: ../index.php");
    }
} else {
    $_SESSION['errReg'] = "Такой пользователь уже существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>