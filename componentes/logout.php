<?php
require_once(__DIR__ . '/../helpers/Session.php');

Session::destroy();
header("Location: ../index.php?sw=3");
exit();
?>