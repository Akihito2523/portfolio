<?php
session_start();
require_once('../lib/functions.php');
require_once('../config/env.php');
require_once("DataAccessUser.php");
require_once("../includes/admin_header.php");

$form = new Dbc();
$result = $form->Detail($_GET['id']);

$id = $result['id'];
$name = $result['name'];

?>

<main class="">
  <form action="/php/thanks.php" method="post" name="demoForm" class="form_confirm">
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">氏名</dt>
      <dd class="form_confirm_value"><?php //echo h($name); 
                                      ?></dd>
      <dd class="form_confirm_value"><?php echo $name ?></dd>

    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">電話番号</dt>
      <dd class="form_confirm_value"><?php //echo h($data['tel']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">メールアドレス</dt>
      <dd class="form_confirm_value"><?php //echo h($data['email']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">性別</dt>
      <dd class="form_confirm_value"><?php //echo h($data['gender']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">チェックボックス</dt>
      <dd class="form_confirm_value"><?php //echo $genreInfo; 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">都道府県</dt>
      <dd class="form_confirm_value"><?php //echo h($data['pref']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">日時</dt>
      <dd class="form_confirm_value"><?php //echo h($data['datetimelocal']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">テキストエリア</dt>
      <dd class="form_confirm_value"><?php //echo h($data['textarea']); 
                                      ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">パスワード</dt>
      <dd class="form_confirm_value">*****</dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_confirm_title">利用規約</dt>
      <dd class="form_confirm_value"><?php //echo h($data['checkbox_name']); 
                                      ?></dd>
    </dl>

    <div class="form_confirm_btn_block">
      <a class="el_btn el_btn_top" href="top.php">Topに戻る</a>
    </div>

    <!-- hiddenパラメータ -->
    <input type="hidden" name="name" value="<?php //echo h($data['name']); 
                                            ?>">
    <input type="hidden" name="tel" value="<?php //echo h($tel); 
                                            ?>">
  </form>
</main>

