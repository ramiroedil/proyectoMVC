<?php
require_once(__DIR__ . '/../helpers/Session.php');

Session::destroy();
header("Location: ../inicio_sesion.php?sw=3");
exit();
?>