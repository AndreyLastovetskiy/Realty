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

// запишем в переменную id здания, которое мы передали через ссылку 
$id_const = $_GET['id'];

// отправим запрос в БД, на выборку конкретного здания,
// по его id, которое мы записали в перменную 
$select_const = mysqli_query($link, "SELECT * FROM `construction`
                                    WHERE `id` = '$id_const'
");

// превратим ответ из БД, в ассоциативный массив,
// чтобы можно было обращаться к отдельным полям таблицы, по их именам
$select_const = mysqli_fetch_assoc($select_const);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://cdn.tiny.cloud/1/fipw5p8ktoulbzn13x05gn3k023y7zotl1ttiifwjubct86w/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <title>Здание - <?= $select_const['name']; ?></title>
</head>
<body>
    <a href="./home.php">Назад</a>
    <br>
    <?php
    // сделаем проверку на пользователя, если id_group в куках, равно 2,
    // тогда мы выведем данную форму (ДЛЯ ВЛАДЕЛЬЦА ЗДАНИЙ)
    if($_COOKIE['id_group'] == 2) { ?>
    <a href="./delete-const.php?id=<?= $id_const ?>">Удалить здание</a>
    <h2>Добавить квартиру</h2>
    <form action="./vendor/create-room.php" method="post" enctype="multipart/form-data" class="form-create-flat">
        <input type="hidden" name="id_const" value="<?= $id_const; ?>">
        <input type="text" name="name" placeholder="Название">
        <textarea name="descrip" placeholder="Краткое описание" id="editor"></textarea>
        <input type="text" name="square_meter" placeholder="Кв.м">
        <input type="text" name="price" placeholder="Цена">
        <input type="file" name="flat_img">
        <button>Добавить</button>
    </form>
    <?php } ?>
    <h2>Информация о здании</h2>
    <div class="construction-info">
        <p>Название: <strong><?= $select_const['name']; ?></strong></p>
        <img src="<?= "./" . $select_const['const_img']; ?>">
    </div>
    <h2>Квартиры</h2>
    <?php
    // отправим запрос в БД, на выборку всех свободных квартир в конкретном здании
    $select_flats = mysqli_query($link, "SELECT * FROM `flat` 
                                        WHERE `id_const` = '$id_const' AND `free` = '0' 
                                        ORDER BY `id` ASC
    ");

    // превратим ответ из БД в ассоциативный, обычный массив или в оба массива, чтобы можно было
    // обращаться к отдельным полям таблицы, по их индексам 
    $select_flats = mysqli_fetch_all($select_flats);

    // переберем данный ответ при помощи цикла и выведем нужную информацию 
    foreach($select_flats as $sf) { ?>
        <a href="./flat.php?id=<?= $sf[0] ?>"><?= $sf[2]; ?></a>
    <?php } ?>

<script>
    tinymce.init({
        selector: 'textarea#editor',  //Change this value according to your HTML
        auto_focus: 'element1',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    }); 
</script>
</body>
</html>