<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessUser.php');
require_once("../includes/admin_header.php");


$form = new Dbc();
$result = $form->Delete($_GET['id']);
?>


<div class="thanks_message">ユーザーIDを削除しました。</div>
<div class="form_confirm_btn_block">
    <a class="el_btn el_btn_top" href="top.php">Topに戻る</a>
</div>
