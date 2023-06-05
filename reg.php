<?php
// стартуем сессию, чтобы через нее передавать ошибки из формы
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form action="./vendor/reg.php" method="post" class="form-login">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <input type="password" name="cpassword" placeholder="Подтверждение пароля">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="Телефон">
        <input type="text" name="full_name" placeholder="ФИО">
        <button>Зарегистрироваться</button>
    </form>
    <?php
    // проверка на пустоту элемента массива с ошибками
    // смысл проверки, если пустой элемент, то выводим пустоту,
    // если элемент не пустой, то выводим его содержимое
    if(empty($_SESSION['errReg'])) {
        echo "";
    } else {
        echo $_SESSION['errReg'];
    }
    
    // удаляем сессию, чтобы при перезагрузке страницы ошибка удалялась
    session_destroy();
    ?>
    <br>
    <a href="./index.php">Войти</a>
</body>
</html>