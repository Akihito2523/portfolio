<?php
session_start();
require_once('../lib/functions.php');

// セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
$data = isset($_SESSION['data']) ? $_SESSION['data'] : [
  'name' => '',
  'tel' => '',
  'email' => '',
  'email_confirm' => '',
  'gender' => '',
  'genre' => [],
  'pref' => '',
  'datetimelocal' => '',
  'textarea' => '',
  'password' => '',
  'password_confirm' => '',
  'checkbox_name' => ''
];

var_dump($data);
// セッションからデータを取得
// $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
if ($data['gender'] === 'man') {
  $data['gender'] = '男性';
} elseif ($data['gender'] === 'woman') {
  $data['gender'] = '女性';
} elseif ($data['gender'] === 'others') {
  $data['gender'] = 'その他';
}


$genreInfo = '';
if (is_array($data['genre'])) {
  foreach ($data['genre'] as $item) {
    $genreInfo .= h($item) . '  ';
  }
}

?>

<?php require_once("../includes/header.php"); ?>

<main class="">
  <form action="thanks.php" method="post" name="demoForm" class="form">
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">氏名</dt>
      <dd class="form_confirm_value"><?php echo h($data['name']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">電話番号</dt>
      <dd class="form_confirm_value"><?php echo h($data['tel']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">メールアドレス</dt>
      <dd class="form_confirm_value"><?php echo h($data['email']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">性別</dt>
      <dd class="form_confirm_value"><?php echo h($data['gender']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">チェックボックス</dt>
      <dd class="form_confirm_value"><?php echo $genreInfo; ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">都道府県</dt>
      <dd class="form_confirm_value"><?php echo h($data['pref']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">日時</dt>
      <dd class="form_confirm_value"><?php echo h($data['datetimelocal']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">テキストエリア</dt>
      <dd class="form_confirm_value"><?php echo h($data['textarea']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">パスワード</dt>
      <dd class="form_confirm_value">*****</dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">利用規約</dt>
      <dd class="form_confirm_value"><?php echo h($data['checkbox_name']); ?></dd>
    </dl>

    <div class="form_confirm_btn_block">
      <a class="el_btn el_btn_back" href="input.php">戻る</a>
      <input type="submit" value="送信" class="el_btn el_btn_submit">
    </div>

    <!-- hiddenパラメータ -->
    <input type="hidden" name="name" value="<?php echo h($data['name']); ?>">
    <input type="hidden" name="tel" value="<?php echo h($tel); ?>">
  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
