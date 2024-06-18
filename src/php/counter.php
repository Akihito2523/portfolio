<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$counter_file = '../../counter.txt';
$counter_length = 8;

// ファイルを読み書き可能なモードで開く
$fp = fopen($counter_file, 'r+');

if ($fp){
    if (flock($fp, LOCK_EX)){

        $counter = fgets($fp, $counter_length); // 変数名を修正
        $counter++;

        rewind($fp);

        if (fwrite($fp,  $counter) === FALSE){
            print('ファイル書き込みに失敗しました');
        }

        flock($fp, LOCK_UN);
    }
}

fclose($fp);

$format = '%0'.$counter_length.'d'; // 変数名を修正
$new_counter = sprintf($format, $counter);
print('訪問者数:'.$new_counter.'人目です');

?>
<p><a href="user_top.php">戻る</a></p>

</body>
</html>
