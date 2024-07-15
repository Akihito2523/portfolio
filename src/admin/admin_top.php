<?php
session_start();

// セッションから会員idとnameを取得
$id = $_SESSION['id'];
$name = $_SESSION['data']['name'] ?? $_SESSION['name'];

require_once("../config/variable.php");
require_once('../lib/functions.php');
require_once('../config/env.php');
require_once('../includes/admin_header.php');
require_once('DataAccessUser.php');
require_once('DataAccessAdmin.php');

// $nameを$_SESSION['data']に追加する
// admin_update.phpで名前を更新するため


$user = new User();
$userDb = $user->UserDbRead();
$userDbResults = $userDb['result'];

// ユーザーがログインしているか確認
if (!$id) {
    header('Location: admin_signin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = h($_POST['keyword'] ?? '');
    $genre = isset($_POST['genre']) ? $_POST['genre'] : [];

    $data = [
        'keyword' => $keyword,
        'genre' => $genre,
    ];

    $form = new User();
    $formData = $form->UserDbSearch(['keyword' => $keyword]);
}
?>

<div class="adminName"><?php echo h($name); ?>さんログイン中</div>


<div id="modal-bg"></div>

<div id="modal-container">
    <div class="modal-container-block">
        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z' fill='%23fff'%3E%3C/path%3E%3C/svg%3E">
        <p class="">検索</p>
    </div>
    <form action="admin_top.php" method="post" class="">

        <!-- <div class=""> -->
        <!-- 
        <div id="js-checkbox">
            <label for="js-checkbox" class="form_input_title form_input_title_checkbox"></label>
            <?php foreach ($genre as $item) : ?>
                <label class="form_input_label">
                    <input type="checkbox" name="genre[]" class="form_input_value_checkbox" value="<?php echo h($item); ?>" <?php echo in_array($item, $data['genre'] ?? []) ? 'checked' : ''; ?>>
                    <?= h($item) ?>
            <?php endforeach; ?>
        </div> -->

        <div class="form_search_btn_block">
            <input type="search" name="keyword" placeholder="名前検索" class="form_input_value form_input_search" value="<?php echo $keyword = $keyword ?? ''; ?>">
            <input type="submit" name="search" value="検索" class="el_btn_search">
        </div>
    </form>
    <p class="">お探しの情報はこちらですか</p>
    <div id="modal-close">×</div>
</div>

<div class="modal-icon">
    <p class="table_explanation">IDをクリックすると詳細画面へ進みます</p>
    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z' fill='%23fff'%3E%3C/path%3E%3C/svg%3E" id="modal-open">
</div>



<div class="tb_wrap">
    <table class="table">
        <thead class="table_thead">
            <tr class="table_tr">
                <th>ID</th>
                <th>氏名</th>
                <th>電話番号</th>
                <th>メールアドレス</th>
                <th>性別</th>
                <th>チェックボックス</th>
                <th>都道府県</th>
                <th>写真</th>
                <th>テキストエリア</th>
                <th>登録日時</th>
                <th>削除ボタン</th>
            </tr>
        </thead>
        <tbody class="table_tbody">
            <?php if ($userDbResults) : ?>
                <?php foreach ($formData = $formData ?? $userDbResults as $column) : ?>

                    <tr class="table_tr">
                        <td><a href="/src/admin/user_detail.php?id=<?php echo h($column["id"]); ?>" class="form_input_link" ontouchstart=""><?php echo h($column["id"]); ?></a></td>
                        <td><?php echo h($column["name"]); ?></td>
                        <td><?php echo h($column["tel"]); ?></td>
                        <td><?php echo h($column["email"]); ?></td>
                        <td><?php echo h($column["gender"]); ?></td>
                        <td><?php echo h($column["genre"]); ?></td>
                        <td><?php echo h($column["pref"]); ?></td>
                        <td class="table_td"><img src="<?php echo h($column["image_path"]); ?>" alt=""></td>
                        <td><?php echo h($column["textarea"]); ?></td>
                        <td><?php echo h($column["created_at"]); ?></td>
                        <td>
                            <a href="/src/admin/user_delete.php?id=<?php echo $column['id']; ?>" class="js-btndelete form_input_link" ontouchstart="">削除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="scroll-info">横スクロールをしてください。</div>
</div>

<div class="overlay" id="js-overlay">
    <section class="overlay-section">
        <p class="overlay-name"><?php echo h($column["name"]); ?></p>
        <img class="overlay-image" id="js-overlay-image">
        <div class="close-button" id="js-close-button">×</div>
    </section>
</div>


<form action="admin_signout.php" method="post">
    <input type="submit" name="logout" value="ログアウト" class="el_btn el_btn_top">
</form>


<?php require_once("../includes/footer.php"); ?>
