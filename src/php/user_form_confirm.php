<?php
session_start();
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/admin_header.php");

// CSRFトークンを生成
$csrf_token = setToken();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];


// セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $data = [
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'tel' => h($_POST['tel'] ?? ''),
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
    'gender' => h($_POST['gender'] ?? ''),
    // $_POST['genre'] が設定かつ配列の場合、array_map関数を使って $_POST['genre'] の各要素をエスケープをし$data['genre']に格納、設定されていない場合は空の配列 [] を格納
    'genre' => isset($_POST['genre']) && is_array($_POST['genre']) ? array_map('h', $_POST['genre']) : [],
    'pref' => h($_POST['pref'] ?? ''),
    'datetimelocal' => h($_POST['datetimelocal'] ?? ''),
    'image_path' => $_POST['image_path'] ?? '',
    // 'image_path' => $_FILES['image_path']['name'] ?? '',
    'textarea' => h($_POST['textarea'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
    'checkbox_name' => h($_POST['checkbox_name'] ?? '')
  ];



  $user = new User();
  $result = $user->UserDbCreate($data);

  if ($result) {
    $_SESSION['data'] = $data;
    header("Location: user_form_thanks.php");
    exit;
  } else {
    header('Location: user_form_confirm.php');
    exit();
  }
} else {

  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'genre' => [],
    'pref' => '',
    'datetimelocal' => '',
    'image_path' => '',
    'textarea' => '',
    'password' => '',
    'password_confirm' => '',
    'checkbox_name' => ''
  ];
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
}
// $image_path = $data['image_path'] ?? '';
// var_dump($image_path);
// exit('exitを実行中') . '<br>';
?>

<main class="">
  <form action="" method="post" name="demoForm" class="form" enctype="multipart/form-data">
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
      <dt class="form_input_title form_confirm_title">写真</dt>
      <dd class="form_confirm_value">
        <?php if (!empty($data['image_path']['name'])) : ?>
          <?php echo $data['image_path']['name']; ?>
        <?php else : ?>
          画像がアップロードされていません
        <?php endif; ?>
      </dd>
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

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>
    <div class="form_confirm_btn_block">
      <a class="el_btn el_btn_back" href="user_form_regist.php">戻る</a>
      <input type="submit" value="送信" class="el_btn el_btn_submit">
    </div>

    <!-- hiddenパラメータ -->
    <input type="hidden" name="name" value="<?php echo h($data['name']); ?>">
    <input type="hidden" name="tel" value="<?php echo h($data['tel']); ?>">
    <input type="hidden" name="email" value="<?php echo h($data['email']); ?>">
    <input type="hidden" name="gender" value="<?php echo h($data['gender']); ?>">
    <input type="hidden" name="genre" value="<?php echo $genreInfo; ?>">
    <input type="hidden" name="pref" value="<?php echo h($data['pref']); ?>">
    <input type="hidden" name="datetimelocal" value="<?php echo h($data['datetimelocal']); ?>">
    <input type="hidden" name="image_path" value="<?php echo h($data['image_path']['name']); ?>">
    <input type="hidden" name="textarea" value="<?php echo h($data['textarea']); ?>">
    <input type="hidden" name="password" value="<?php echo h($data['password']); ?>">
    <input type="hidden" name="checkbox_name" value="<?php echo h($data['checkbox_name']); ?>">
  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
