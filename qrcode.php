<?php
// génération du QRcode
include './phpqrcode/qrlib.php';
QRcode::png('localhost:3000/user_informations.php');
?>
