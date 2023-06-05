<?php
// стартуем сессию, чтобы мы могли получать ошибки из формы
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <form action="./vendor/login.php" method="post" class="form-login">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <button>Войти</button>
    </form>
    <?php
    // проверка на пустоту элемента массива с ошибками
    // смысл проверки, если пустой элемент, то выводим пустоту,
    // если элемент не пустой, то выводим его содержимое
    if(empty($_SESSION['errLogin'])) {
        echo "";
    } else {
        echo $_SESSION['errLogin'];
    }

    // удаляем сессию, чтобы при перезагрузке страницы ошибка удалялась
    session_destroy();
    ?>
    <br>
    <a href="./reg.php">Зарегистрироваться</a>
</body>
</html>