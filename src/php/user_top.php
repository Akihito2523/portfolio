<?php
session_start();
require_once("../config/variable.php");
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/header.php");

$user = new User();
$userDb = $user->UserDbRead();
$userDbResults = $userDb['result'];
$userDbCount = $userDb['count'];
?>

<?php

$imagePerPage = intval($_SESSION['$imagePerPage'] ?? 1);
// 1ページあたりの表示枚数
$imagePerPage = isset($_GET['imagePerPage']) ? intval($_GET['imagePerPage']) : $imagePerPage;

$_SESSION['$imagePerPage'] = $imagePerPage;

// ページネーション数を計算（intval：数値にキャスト）（ceil：小数点以下を切り上げた整数）
$totalPage = intval(ceil($userDbCount / $imagePerPage)); //3

// 現在のページ番号を取得する（クエリパラメータから取得）
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$currentPage = intval(max(1, min($currentPage, $totalPage))); // 範囲を制限

// startからendまでの整数の配列を返す
$items = range(1, $userDbCount);

?>

<form action="admin_top.php" method="post" class="">
    <div class="form_search_btn_block">
    <div id="js-checkbox">
      <label for="js-checkbox" class="form_input_title form_input_title_checkbox">チェックボックス</label>
      <?php foreach ($genre as $item) : ?>
        <label class="form_input_label">
          <input type="checkbox" name="genre[]" class="form_input_value_checkbox" value="<?php echo h($item); ?>" <?php echo in_array($item, $data['genre'] ?? []) ? 'checked' : ''; ?>>
          <?= h($item) ?>
        </label>
      <?php endforeach; ?>
    </div>
        <input type="search" name="keyword" placeholder="入力して検索" class="form_input_value form_input_search">
        <input type="submit" name="search" value="検索" class="el_btn_search">
    </div>
</form>

<form id="js-select_image_gallery_form" action="" method="get">
    <div>1 - 4件 / 4件</div>
    <div class="form_input_block">
        <select name="imagePerPage" id="js-select_image_gallery" class="form_input_value image_gallery_perPage">
            <option value="3" <?php if (isset($_SESSION['$imagePerPage']) && $_SESSION['$imagePerPage'] == 3) echo "selected"; ?>> 3件 ▼</option>
            <option value="6" <?php if (isset($_SESSION['$imagePerPage']) && $_SESSION['$imagePerPage'] == 6) echo "selected"; ?>> 6件</option>
            <option value="9" <?php if (isset($_SESSION['$imagePerPage']) && $_SESSION['$imagePerPage'] == 9) echo "selected"; ?>> 9件</option>
            <!-- <option value="6">6件</option> -->
            <!-- <option value="9">9件</option> -->
        </select>
    </div>
</form>

<!-- <?php foreach ($prefs as $pref) : ?>
    <option value="<?= h($pref) ?>" <?php if (isset($data['pref']) && $data['pref'] === $pref) echo "selected"; ?>>
    <?= h($pref) ?></option>
<?php endforeach; ?> -->

<section class="image_gallery" id="image_gallery">
    <div class="image_gallery_container">
        <?php
        // ページネーションで表示するデータの範囲を計算
        $startIndex = ($currentPage - 1) * $imagePerPage;
        // $startIndexから3件取得して表示
        $currentPageItems = array_slice($userDbResults, $startIndex, $imagePerPage);
        foreach ($currentPageItems as $column) :
        ?>
            <?php //for ($i = 0; $i < 3; $i++) { 
            ?>
            <div class="image_gallery_box">
                <span></span>
                <img src="<?php echo h($column["image_path"]); ?>" alt="" class="image_gallery_image">
                <h3 class="image_gallery_title">撮影者：<?php echo h($column["name"]); ?></h3>
                <div class="image_gallery_icons">
                    <p><?php echo nl2br(h($column["textarea"])); ?></p>
                    <a href="">リンク</a>
                </div>
            </div>
            <?php // } 
            ?>
        <?php endforeach; ?>
    </div>
</section>


<div class="pagination">
    <!-- 前へリンクの表示 -->
    <?php if ($currentPage === 1) : ?>
        <!-- <p class="form_input_error_message">前へ</p> -->
        <a href="" class="pagination_link">前へ</a>
    <?php else : ?>
        <a href="?page=<?php echo $currentPage - 1; ?>" class="pagination_link">前へ</a>
    <?php endif; ?>

    <?php //echo gettype($totalPage) ; ?>
    <!-- ページ番号の表示 -->
    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
        <!-- 選択されているページネーション -->
        <?php if ($i === $currentPage) : ?>
            <div class="pagination_link pagination_link_active"><?php echo $i; ?></div>
        <?php else : ?>
            <a href="?page=<?php echo $i; ?>" class="pagination_link"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- 次へリンクの表示 -->
    <?php if ($currentPage === $totalPage) : ?>
        <a href="" class="pagination_link">次へ</a>
    <?php else : ?>
        <a href="?page=<?php echo $currentPage + 1; ?>" class="pagination_link">次へ</a>
    <?php endif; ?>
    <a href="?page=<?php echo $totalPage; ?>" class="pagination_link">最後</a>

</div>


<?php require_once("../includes/footer.php"); ?>
