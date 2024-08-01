<?php
session_start();
// CSRFトークンを生成
unset($_SESSION['csrf_token']);

require_once("../config/variable.php");
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/header.php");

// ページネーションのセッションを削除
unset($_SESSION['$imagePerPage']);

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = [
    'csrf_token' => isset($_POST['csrf_token']) ? h($_POST['csrf_token']) : '',
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'tel' => h($_POST['tel'] ?? ''),
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
    'gender' => h($_POST['gender'] ?? ''),
    // $_POST['genre'] が設定かつ配列の場合、array_map関数を使って $_POST['genre'] の各要素をエスケープをし$data['genre']に格納、設定されていない場合は空の配列 [] を格納
    'genre' => isset($_POST['genre']) && is_array($_POST['genre']) ? array_map('h', $_POST['genre']) : [],
    'pref' => h($_POST['pref'] ?? ''),
    'image_path' => $_FILES['image_path'] ?? '',
    // 'tmp_path' => $_FILES['image_path']['tmp_path'] ?? '',
    'textarea' => h($_POST['textarea'] ?? ''),
    'checkbox_name' => h($_POST['checkbox_name'] ?? '')
  ];

  $error = validateUserForm($data);
  $imageError = validateImage($_FILES['image_path'], $error);

  if (empty($error) && empty($imageError)) {
    $_SESSION['data'] = $data;
    header("Location: user_form_confirm.php");
    exit();
  } else {
    // エラーがある場合はエラーメッセージをセッションに保存して再度フォームを表示する
    // $_SESSION['error'] = '入力内容に誤りがあります。';
    // header('Location: user_form.php');
  }
} else {
  // unset($_SESSION['data']);
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'genre' => [],
    'checkbox' => '',
    'pref' => '',
    'image_path' => '',
    // 'tmp_path' => '',
    'textarea' => '',
    'checkbox_name' => ''
  ];
}

// unset($_SESSION['data']);

?>

<main class="">
  <h2 class="contents-title">ユーザー登録</h2>

  <form action="" method="post" name="form" class="form container" enctype="multipart/form-data">
    <!-- CSRFトークンをフォームに埋め込む -->
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

    <div class="form_input_block">
      <label for="js-text" class="form_input_title">氏名</label>
      <span class="need form_input_need">【必須】</span>
      <input type="text" name="name" class="form_input_value" id="js-text" maxlength="64" value="<?= h($data['name'] ?? '') ?>" autocomplete="name" aria-describedby="js-textMessage">
      <?php if (isset($error['name'])) : ?>
        <p class="form_input_error_message" id="js-textMessage"><?= $error['name'] ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-textMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-tel" class="form_input_title">電話番号</label>
      <span class="need form_input_need">【必須】</span>
      <input type="tel" name="tel" class="form_input_value" id="js-tel" value="<?= h($data['tel'] ?? ''); ?>" autocomplete="tel" aria-describedby="js-telMessage">
      <?php if (isset($error['tel'])) : ?>
        <p class="form_input_error_message" id="js-telMessage"><?= $error['tel'] ?></p>
      <?php else : ?>
        <p class="form_input_error_message" id="js-telMessage"></p>
      <?php endif; ?>
      <span class="form_input_caution">例：09012345678</span>
    </div>

    <div class="form_input_block">
      <label for="js-email" class="form_input_title">メールアドレス</label>
      <span class="need form_input_need">【必須】</span>
      <input type="email" name="email" class="form_input_value" id="js-email" value="<?= h($data['email'] ?? ''); ?>" autocomplete="email" aria-describedby="js-emailMessage">
      <?php if (isset($error['email'])) : ?>
        <p class="form_input_error_message" id="js-emailMessage"><?= $error['email'] ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email-confirm" class="form_input_title">メールアドレス (確認用)</label>
      <span class="need form_input_need">【必須】</span>
      <input type="email" name="email_confirm" class="form_input_value" id="js-email-confirm" value="<?= h($_POST['email_confirm'] ?? ''); ?>" aria-describedby="js-emailMessage-confirm">
      <?php if (isset($error['email_confirm'])) : ?>
        <p class="form_input_error_message"><?= $error['email_confirm'] ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage-confirm"></p>
      <span class="form_input_caution">上記と同じメールアドレスを入力してください</span>
    </div>

    <!-- $data配列内に'gender'キーが存在しかつvalue値と等しければ、trueを返しchecked属性を出力 -->
    <div class="form_input_block" id="js-radio">
      <fieldset>
        <legend class="form_input_title">性別<span class="need form_input_need"> 【必須】</span></legend>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="man" <?= isset($data['gender']) && $data['gender'] === 'man' ? 'checked' : ''; ?> />男性
        </label>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="woman" <?= isset($data['gender']) && $data['gender'] === 'woman' ? 'checked' : ''; ?> />女性
        </label>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="others" <?= isset($data['gender']) && $data['gender'] === 'others' ? 'checked' : ''; ?> />その他
        </label>
      </fieldset>
      <?php if (isset($error['gender'])) : ?>
        <p class="form_input_error_message radio_error_message"><?= $error['gender'] ?></p>
      <?php endif; ?>
    </div>

    <div class="form_input_block" id="js-checkbox">
      <label for="js-checkbox" class="form_input_title form_input_title_checkbox">チェックボックス</label>
      <?php foreach ($genre as $item) : ?>
        <label class="form_input_label">
          <input type="checkbox" name="genre[]" class="form_input_value_checkbox" value="<?= h($item); ?>" <?= in_array($item, $data['genre'] ?? []) ? 'checked' : ''; ?>>
          <?= h($item); ?>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="form_input_block">
      <label for="js-select" class="form_input_title">都道府県</label>
      <select name="pref" id="js-select" class="form_input_value" aria-describedby="js-prefError">
        <option value="">▼選択してください</option>
        <?php foreach ($prefectures as $region => $prefs) : ?>
          <optgroup label="<?= h($region); ?>">
            <?php foreach ($prefs as $pref) : ?>
              <option value="<?= h($pref); ?>" <?= isset($data['pref']) && $data['pref'] === $pref ? 'selected' : ''; ?>>
                <?= h($pref); ?></option>
            <?php endforeach; ?>
          </optgroup>
        <?php endforeach; ?>
      </select>
      <?php if (isset($error['pref'])) : ?>
        <p class="form_input_error_message radio_error_message" id="js-prefError"><?= $error['pref'] ?></p>
      <?php endif; ?>
    </div>

    <div class="form_input_block">
      <label for="js-image" class="form_input_title">写真アップロード</label>
      <span class="need form_input_need">【必須】</span>
      <div class="form_input_image_block">
        <input type="file" name="image_path" class="" id="js-image" accept="image/*" value="">
        <!-- <img src="<?php //echo $result['image_path'] 
                        ?>" alt="" id="js-imagePreview"> -->
        <img src="<?= isset($result['image_path']) ? h($result['image_path']) : ''; ?>" alt="" id="js-imagePreview">
      </div>
      <?php if (isset($imageError['image_path'])) : ?>
        <p class="form_input_error_message js-image_path_error" id="js-imageMessage"><?= $imageError['image_path'] ?></p>
      <?php endif; ?>
      <span class="form_input_caution">※ JPEG、PNG、FIFのみ</span>
    </div>

    <div class="form_input_block">
      <label for="js-textarea" class="form_input_title">テキストエリア</label>
      <span class="need form_input_any">任意</span>
      <textarea name="textarea" id="js-textarea" class="form_input_value form_input_value_textarea" maxlength="140" placeholder="140文字以下"><?= h($data['textarea'] ?? ''); ?></textarea>
      <p class="form_input_textarea_message">現在
        <span id="js-textareaCount">0</span>文字入力中です。
      </p>
    </div>

    <div class="form_input_block">
      <p class="form_input_title">個人情報の取り扱いについて</p>
      <div id="privacyPolicy" class="form_input_privacy_policy">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nihil minus excepturi harum, labore earum odio. Minima itaque sit labore, nostrum ea
      </div>
    </div>

    <div class="form_input_block">
      <label class="form_input_label">
        <input type="checkbox" name="checkbox_name" class="form_input_value_checkbox" id="js-check" value="同意" <?= $data['checkbox_name'] === '同意' ? 'checked' : ''; ?>>
        <label for="js-check" class="form_input_title">個人情報保護方針に同意する</label>
      </label>
      <?php if (isset($error['checkbox_name'])) : ?>
        <p class="form_input_error_message"><?= $error['checkbox_name'] ?></p>
      <?php endif; ?>
      <span class="need form_input_need">【必須】</span>
    </div>

    <div class="form_btn_block">
      <a class="el_btn el_btn_back" href="user_top.php">戻る</a>
      <input type="submit" value="確認" class="el_btn el_btn_submit" id="js-submit" disabled>
    </div>
  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
