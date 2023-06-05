<?php
// удаляем куки пользователю
setcookie("id_user", null, -1, "/");
setcookie("id_group", null, -1, "/");

// перенаправляем на страницу авторизации 
header("Location: ./index.php");
?>