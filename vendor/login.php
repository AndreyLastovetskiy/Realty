<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// подключим БД
require_once("../db/db.php");

// запишем данные из формы в переменные
$login = $_POST['login'];
$password = $_POST['password'];

// отправим запрос в БД, на выборку пользователя, где логин в таблице,
// совпадает с логином из формы
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");

// превратим ответ из БД, в ассоциативный массив, чтобы можно было обращаться,
// к отдельным полям таблицы, по их именам
$select_user = mysqli_fetch_assoc($select_user);

// структура проверки
// если не найден пользователь с логином, который мы отправили из формы,
// то мы выдаем ошибку, что такого пользователя не существует,
// если не пустой, то проверяем хэши паролей, если они совпали, 
// создаем куки и перенаправляем на домашнюю страницу
// или выдаем ошибку, что пароль не верный
if(empty($select_user)) {
    $_SESSION['errLogin'] = "Такого пользователя не существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    if(password_verify($password, $select_user['password'])) {
        setcookie("id_user", $select_user['id'], time()+28800, "/");
        setcookie("id_group", $select_user['idgroup'], time()+28800, "/");
        header("Location: ../home.php");
    } else {
        $_SESSION['errLogin'] = "Пароль введен неверно!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

?>