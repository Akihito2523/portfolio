<?php
require_once('../lib/functions.php');
require_once("../config/variable.php");
session_start();

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // $_POSTがセットされている場合その値を、セットされていない場合は空の文字列を返す
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
    'textarea' => h($_POST['textarea'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
    'checkbox_name' => h($_POST['checkbox_name'] ?? '')
  ];

  // var_dump($data);
  // バリデーション関数を呼び出し
  $error = validateInputFormData($data);
  // var_dump($error);

  // エラーがなければ確認ページに遷移
  if (empty($error)) {
    //$_SESSION["name"] = $data["name"];
    // 入力値をセッションに保存
    $_SESSION['data'] = $data;
    header("Location: confirm.php");
    // リダイレクト後にスクリプトの実行を終了する
    exit;
  }
} else {
  // セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'genre' => [],
    'checkbox' => '',
    'pref' => '',
    'datetimelocal' => '',
    'textarea' => '',
    'password' => '',
    'password_confirm' => '',
    'checkbox_name' => ''
  ];
}

// var_dump($data);
?>


<?php require_once("../includes/header.php"); ?>

<main class="">
  <h2 class="contents-title">contact</h2>

  <form action="" method="post" name="demoForm" class="form_input">

    <div class="form_input_block">
      <label for="js-text" class="form_input_title">氏名</label>
      <span class="need js-need">必須</span>
      <input type="text" name="name" class="form_input_value" id="js-text" maxlength="20" autofocus value="<?php echo h($data['name']); ?>">
      <?php if (isset($error['name'])) : ?>
        <p class="form_input_error_message"><?= $error['name']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-textMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-tel" class="form_input_title">電話番号</label>
      <span class="need js-need">必須</span>
      <input type="tel" name="tel" class="form_input_value" id="js-tel" placeholder="例）09012345678" value="<?php echo h($data['tel']); ?>">
      <?php if (isset($error['tel'])) : ?>
        <p class="form_input_error_message"><?php echo $error['tel']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-telMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email" class="form_input_title">メールアドレス</label>
      <span class="need js-need">必須</span>
      <input type="email" name="email" class="form_input_value" id="js-email" value="<?php echo h($data['email']); ?>">
      <?php if (isset($error['email'])) : ?>
        <p class="form_input_error_message"><?php echo $error['email']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email-confirm" class="form_input_title">メールアドレス(確認用)</label>
      <span class="need js-need">必須</span>
      <input type="email" name="email_confirm" class="form_input_value" id="js-email-confirm" value="<?php echo isset($_POST['email_confirm']) ? h($_POST['email_confirm']) : ''; ?>">
      <?php if (isset($error['email_confirm'])) : ?>
        <p class="form_input_error_message"><?php echo $error['email_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage-confirm"></p>
    </div>

    <!-- $data配列内に'gender'キーが存在しかつvalue値と等しければ、trueを返しchecked属性を出力 -->
    <div id="js-radio">
      <fieldset>
        <legend class="form_input_title">性別</legend>
        <span class="need js-need">必須</span>
        <label class="form_input_label"><input type="radio" name="gender" value="man" <?php if (isset($data['gender']) && $data['gender'] === 'man') echo 'checked'; ?> />男性</label>
        <label class="form_input_label"><input type="radio" name="gender" value="woman" <?php if (isset($data['gender']) && $data['gender'] === 'woman') echo 'checked'; ?> />女性</label>
        <label class="form_input_label"><input type="radio" name="gender" value="others" <?php if (isset($data['gender']) && $data['gender'] === 'others') echo 'checked'; ?> />その他</label>
        <?php if (isset($error['gender'])) : ?>
          <p class="form_input_error_message radio_error_message"><?php echo $error['gender']; ?></p>
        <?php endif; ?>
      </fieldset>
      <fieldset>
        <legend class="form_input_title">ラジオボタン（ドリンク）</legend>
        <label class="form_input_label"><input type="radio" name="drink" value="coke" checked />Coke</label>
        <label class="form_input_label"><input type="radio" name="drink" value="wine" />Wine</label>
      </fieldset>
    </div>

    <div id="js-checkbox">
      <label for="js-checkbox" class="form_input_title">チェックボックス</label>
      <?php foreach ($genre as $item) : ?>
        <label class="form_input_label">
          <input type="checkbox" name="genre[]" value="<?php echo h($item); ?>" <?php echo in_array($item, $data['genre'] ?? []) ? 'checked' : ''; ?>>
          <?= h($item) ?>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="form_input_block">
      <label for="js-select" class="form_input_title">都道府県</label>
      <span class="need js-need">必須</span>
      <select name="pref" id="js-select" class="form_input_value">
        <option value="">▼選択してください</option>
        <?php foreach ($prefectures as $region => $prefs) : ?>
          <optgroup label="<?= h($region) ?>">
            <?php foreach ($prefs as $pref) : ?>
              <option value="<?= h($pref) ?>" <?php if (isset($data['pref']) && $data['pref'] === $pref) echo "selected"; ?>>
                <?= h($pref) ?></option>
            <?php endforeach; ?>
          </optgroup>
        <?php endforeach; ?>
      </select>
      <?php if (isset($error['pref'])) : ?>
        <p class="form_input_error_message radio_error_message"><?php echo $error['pref']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form_input_block">
      <label for="js-start-time" class="form_input_title">開始時間</label>
      <input type="time" id="js-start-time" name="start-time" class="form_input_value">
    </div>

    <div class="form_input_block">
      <label for="js-datetime" class="form_input_title">日時</label>
      <input type="datetime-local" name="datetimelocal" class="form_input_value" id="js-datetime" value="<?php echo $data['datetimelocal']; ?>">
    </div>

    <div class="form_input_block">
      <label for="js-textarea" class="form_input_title">テキストエリア</label>
      <span class="need form_input_any">任意</span>
      <textarea name="textarea" id="js-textarea" class="form_input_value" maxlength="20"><?php echo $data['textarea']; ?></textarea>
      <p class="form_input_textarea_message">現在
        <span id="js-textareaCount">0</span>文字入力中です。
      </p>
    </div>

    <div class="form_input_block">
      <label for="js-password" class="form_input_title">パスワード</label>
      <span class="need js-need">必須</span>
      <input type="password" name="password" class="form_input_value" id="js-password" value="<?php echo h($data['password']); ?>">
      <?php if (isset($error['password'])) : ?>
        <p class="form_input_error_message"><?php echo $error['password']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordMessage"></p>
      <span class="form_input_caution">※半角英数記号8文字以上16文字以下</span>
    </div>

    <div class="form_input_block">
      <label for="js-password-confirm" class="form_input_title">パスワード確認</label>
      <span class="need js-need">必須</span>
      <input type="password" name="password_confirm" class="form_input_value" id="js-password-confirm">
      <?php if (isset($error['password_confirm'])) : ?>
        <p class="form_input_error_message"><?php echo $error['password_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordConfirmMessage"></p>
    </div>

    <div id="privacyPolicy" class="privacy-policy">
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nihil minus excepturi harum, labore earum odio. Minima itaque sit labore, nostrum earum eaque, debitis qui sunt molestias, voluptas accusamus veritatis minus quidem sint cumque inventore eligendi! Suscipit, dolores sed numquam ex eum minus esse, rerum harum accusantium cumque animi commodi ipsa ullam nulla quibusdam? Quis magni, doloribus amet commodi ratione quibusdam nam nobis tempore excepturi laboriosam molestias nulla enim deleniti! Sed impedit ducimus deserunt sunt, tempora amet, temporibus unde reiciendis, animi veritatis a ut aperiam in aspernatur earum. Iusto ipsa aperiam ex eveniet earum similiqueur quos asperiores eius nobis totam error mollitia rem dolor excepturi doloremque molestiae magni porro id exercitationem, sunt fuga minus modi cupiditate quidem? Molestias autem quos voluptates accusantium quod alias distinctio illum nulla. Quis accusamus ipsa obcaecati tempora necessitatibus error qui ipsam eum eveniet delectus placeat animi quo sunt earum, atque numquam tenetur est molestias quas fugit praesentium voluptatibus alias ducimus! Soluta officia sunt at id illo? Commodi optio dolores dolore ducimus unde nobis necessitatibus temporibus doloribus corrupti velit distinctio maiores nulla, cum molestias accusamus, qui sapiente suscipit neque labore ratione quos a eaque error. Provident vel debitis dolores, necessitatibus non in quam fugiat et excepturi a esse? Iusto facere porro inventore deleniti, repellendus eum in voluptatibus odio nulla, officiis magni suscipit distinctio essetate quae aliquam quia amet excepturi dolores ullam provident illum, ad exercitationem expedita sed non impedit, dolor quod natus voluptatem consequuntur incidunt officiis sapiente iure. Libero, explicabo. Modi possimus ab repellendus? Consectetur nihil, aperiam beatae earum fugiat asperiores mollitia modi molestias distinctio harum excepturi sit necessitatibus minima accusamus ullam doloremque officiis. Aspernatur, eius consequatur. Voluptas nobis maxime saepe ipsum fuga voluptatem est ex molestias reiciendis temporibus. Similique, quibusdam beatae esse magni consequatur cum vero, ab ad ullam, facere provident? Ullam, consequatur! Eum nostrum incidunt tempora. Dolore sit veritatis, asperiores numquam iste debitis vel.
    </div>

    <div class="form_input_block">
      <label for="js-check" class="form_input_title">利用規約</label>
      <span class="need js-need">必須</span>
      <label class="form_input_label">
        <input type="checkbox" name="checkbox_name" id="js-check" value="同意" <?php if ($data['checkbox_name'] === '同意') echo 'checked'; ?>>
        同意
      </label>
      <?php if (isset($error['checkbox_name'])) : ?>
        <p class="form_input_error_message"><?php echo $error['checkbox_name']; ?></p>
      <?php endif; ?>
    </div>


    <input type="submit" value="確認" class="el_btn el_btn_submit" id="js-submit" disabled>

  </form>
</main>


<?php require_once("../includes/footer.php"); ?>
