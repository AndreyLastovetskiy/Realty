<?php
// стартуем сессию, чтобы мы могли передавать ошибку в форму 
session_start();

// если пользователь не авторизован, у него не созданы куки,
// если кука с id пользователя пустая, то перенаправляем его на авторизацию
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./index.php");
}

// подключим БД
require_once("./db/db.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">

    <title>Главная</title>
</head>
<body>
    <a href="./logout.php">Выйти</a>
    <?php
    // сделаем проверку на пользователя, если id_group в куках, равно 1,
    // тогда мы выведем данную форму (ДЛЯ АДМИНА)
    if($_COOKIE['id_group'] == 1) { ?>
        <h2>Добавить владельца здания</h2>
        <form action="./vendor/create-owner.php" method="post" class="form-login">
            <input type="text" name="login" placeholder="Логин">
            <input type="password" name="password" placeholder="Пароль">
            <input type="password" name="cpassword" placeholder="Подтверждение пароля"> 
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="phone" placeholder="Телефон">
            <input type="text" name="full_name" placeholder="ФИО">
            <button>Добавить</button>
        </form>

        <?php
        // проверка на пустоту элемента массива с ошибками
        // смысл проверки, если пустой элемент, то выводим пустоту,
        // если элемент не пустой, то выводим его содержимое
        if(empty($_SESSION['errOwn'])) {
            echo "";
        } else {
            echo $_SESSION['errOwn'];
        }

        // удаляем сессию, чтобы при перезагрузке страницы ошибка удалялась
        session_destroy();
        ?>
    <?php } ?>

    <?php
    // сделаем проверку на пользователя, если id_group в куках, равно 2,
    // тогда мы выведем данную форму (ДЛЯ ВЛАДЕЛЬЦА ЗДАНИЙ)
    if($_COOKIE['id_group'] == 2) { ?>
        <h2>Добавить недвижимость</h2>
        <form action="./vendor/create-construction.php" method="post" enctype="multipart/form-data" class="form-login">
            <input type="text" name="name" placeholder="Название здания">
            <input type="text" name="geoposition" placeholder="Место расположения">
            <input type="file" name="const_img">
            <button>Добавить</button>
        </form>

        <h2>Ваша недвижимость</h2>
        <?php
        // запишем id влальца в переменную
        $id_user = $_COOKIE['id_user'];

        // отправим запрос в БД, на выборку зданий, которые добавил конкретный владелец
        $select_const = mysqli_query($link, "SELECT * FROM `construction`
                                            WHERE `id_user` = '$id_user'
                                            ORDER BY `id` DESC
        ");

        // превратим ответ из БД в ассоциативный, обычный массив или в оба массива, чтобы можно было
        // обращаться к отдельным полям таблицы, по их индексам 
        $select_const = mysqli_fetch_all($select_const);

        // переберем данный ответ при помощи цикла и выведем нужную информацию 
        foreach($select_const as $sc) { ?>
            <a href="./construction.php?id=<?= $sc[0] ?>"><?= $sc[2] ?></a>
        <?php } ?>
    <?php } ?>

    <h2>Вся недвижимость</h2>
    <?php
        // отправим запрос в БД, на выборку все зданий, которые есть в БД
        $select_const = mysqli_query($link, "SELECT * FROM `construction`
                                            ORDER BY `id` DESC
        ");

        // превратим ответ из БД в ассоциативный, обычный массив или в оба массива, чтобы можно было
        // обращаться к отдельным полям таблицы, по их индексам 
        $select_const = mysqli_fetch_all($select_const);

        // переберем данный ответ при помощи цикла и выведем нужную информацию 
        foreach($select_const as $sc) { ?>
            <a href="./construction.php?id=<?= $sc[0] ?>"><?= $sc[2] ?></a> <br><br>
    <?php } ?>

    <h2>Ваши сделки</h2>
    <?php
    // запишем в переменную id конкретного пользователя 
    $id_user = $_COOKIE['id_user'];

    // отправим запрос в БД, на выборку всех сделок, которые согласовывал пользователь
    $select_approve = mysqli_query($link, "SELECT * FROM `approve` WHERE `id_client` = '$id_user'");

    // превратим ответ из БД в ассоциативный, обычный массив или в оба массива, чтобы можно было
    // обращаться к отдельным полям таблицы, по их индексам 
    $select_approve = mysqli_fetch_all($select_approve);

    // переберем данный ответ при помощи цикла и выведем нужную информацию 
    foreach($select_approve as $sa) {
        // запишем в переменную id квартиры 
        $select_flat_id = $sa[4];

        // отправим запрос в БД, на выборку конкретной квартиры, которая прописана в сделке 
        $select_flat = mysqli_query($link, "SELECT * FROM `flat` WHERE `id` = '$select_flat_id'");

        // превратим ответ из БД в ассоциативный массив,
        // чтобы можно было обращаться к отдельным полям таблицы, по их именам
        $select_flat = mysqli_fetch_assoc($select_flat); 
    ?>
        <a href="./info-approve.php?id=<?= $sa[0] ?>"><?= $select_flat['name']; ?></a> <br><br>
    <?php } ?>
</body>
</html>