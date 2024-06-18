<?php
session_start();
require_once("../config/variable.php");
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/header.php");

$form = new User();
$formData = $form->UserDbRead();
?>

<form action="admin_top.php" method="post" class="">
    <div class="form_search_btn_block">
        <input type="search" name="keyword" placeholder="名前検索" class="form_input_value form_input_search">
        <input type="submit" name="search" value="検索" class="el_btn_search">
    </div>
</form>

<section class="image_gallery" id="image_gallery">
    <div class="image_gallery_container">
        <?php foreach ($formData as $column) : ?>
            <?php for ($i = 0; $i < 3; $i++) { ?>
                <div class="image_gallery_box">
                    <span></span>
                    <img src="<?php echo h($column["image_path"]); ?>" alt="" class="image_gallery_image">
                    <h3 class="image_gallery_title">撮影者：<?php echo h($column["name"]); ?></h3>
                    <div class="image_gallery_icons">
                        <p><?php echo nl2br(h($column["textarea"])); ?></p>
                        <a href="">リンク</a>
                    </div>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>
</section>



<?php require_once("../includes/footer.php"); ?>
