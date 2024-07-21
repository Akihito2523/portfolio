<?php

/**
 * 各種関数
 *
 * @version $Revision: 4.0.0 $
 * @copyright
 * @author
 */
?>

<?php

/**
 * 各ページごとにタイトルを動的に変更
 * @param
 * @return string タイトル
 */
function getPageTitle()
{
    $pageTitle = '';

    // PHP_SELF から現在のファイル名を取得
    $currentPage = basename($_SERVER['PHP_SELF']);

    // 各ページごとにタイトルを設定
    switch ($currentPage) {
        case 'user_form_regist.php':
        case 'user_form_confirm.php':
        case 'user_form_thanks.php':
            $pageTitle = 'ユーザー登録';
            break;
        case 'user_top.php':
            $pageTitle = 'ユーザートップページ';
            break;
            // 追加のページがあればここに追加
        default:
            $pageTitle = 'デフォルトタイトル';
            break;
    }
    return $pageTitle;
}

/**
 * 文字列をHTML特殊文字に変換（サニタイズ処理）
 * @param string $str 変換する文字列
 * @return string 変換された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF対策用トークンを生成し、セッションに保存する
 * @return string 生成されたCSRFトークン
 */
function setToken()
{
    // トークンを生成
    $csrf_token = bin2hex(random_bytes(32));
    // セッションにトークンを保存
    $_SESSION['csrf_token'] = $csrf_token;
    // トークンを返す
    return $csrf_token;
}

/**
 * IPアドレスを取得する
 * @return string IPアドレス
 */
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // 共有インターネット接続から取得されたIPアドレス
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // プロキシサーバーを経由して取得されたIPアドレス
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // リモートアドレスから取得されたIPアドレス
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * ユーザーエージェント（ブラウザ情報）を取得する
 * @return string ユーザーエージェント
 */
function getUserAgent()
{
    return $_SERVER['HTTP_USER_AGENT'];
}

/**
 * 現在の日時を取得する
 * @return string フォーマットされた日時文字列（YYYY-MM-DD HH:MM）
 */
function getDateTime()
{
    date_default_timezone_set('Asia/Tokyo');
    $today = new DateTime();
    return $today->format("Y-m-d H:i");
}






/**
 * 「admin_signin.php」と「admin_delete_account.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminLogin($data)
{
    $error = [];

    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    }

    if (empty($data['password'])) {
        $error['password'] = 'パスワードを入力してください。';
    }

    return $error;
}

/**
 * 「admin_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminUpdate($data)
{
    $error = [];

    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($data['email_confirm'])) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($data['email_confirm'] !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    return $error;
}

/**
 * 「admin_signup.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminSignup($data)
{
    $error = [];

    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($data['email_confirm'])) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($data['email_confirm'] !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    if (empty($password)) {
        $error['password'] = 'パスワードを入力してください。';
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    } elseif (empty($password_confirm)) {
        $error['password_confirm'] = '確認用パスワードを入力してください。';
    } elseif ($password !== $password_confirm) {
        $error['password_confirm'] = 'パスワードが一致しません。';
    }

    return $error;
}

/**
 * 「admin_password_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminPasswordUpdate($data)
{
    $error = [];

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    if (empty($password)) {
        $error['password'] = 'パスワードを入力してください。';
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    } elseif (empty($password_confirm)) {
        $error['password_confirm'] = '確認用パスワードを入力してください。';
    } elseif ($password !== $password_confirm) {
        $error['password_confirm'] = 'パスワードが一致しません。';
    }

    return $error;
}

/**
 * 「user_form_regist.php」と「user_form_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateUserForm($data)
{
    $error = [];

    // 氏名のバリデーション
    if (empty($_POST['name'])) {
        $error['name'] = '氏名を入力してください。';
    } elseif (mb_strlen($_POST['name']) > 64) {
        $error['name'] = '氏名は64文字以内で入力してください。';
    }

    // 電話番号が空かどうかをチェック
    if (empty($data['tel'])) {
        $error['tel'] = '電話番号を入力してください';
    } else {
        // ハイフンを除去してから正規表現でバリデーション
        $telWithoutHyphen = str_replace('-', '', $data['tel']);
        if (!preg_match('/^(0\d{9,10}|\d{1,4}-\d{1,4}-\d{4})$/', $telWithoutHyphen)) {
            $error['tel'] = '正しい電話番号の形式で入力してください';
        }
    }

    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    }

    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';
    if (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    if (empty($data['gender'])) {
        $error['gender'] = '性別を選択してください。';
    }

    // if (empty($data['pref'])) {
    //     $error['pref'] = '都道府県を選択してください。';
    // }

    return $error;
}

/**
 * 画像ファイルのバリデーションを行う
 * @param array $image アップロードされた画像の情報（$_FILESから取得）
 * @return array エラーメッセージの配列
 */
function validateImage($image, $validateerror)
{
    $error = [];

    $tmp_path = $image["tmp_name"];
    $imageName = $image["name"];

    // ファイルがアップロードされているかを確認
    if (!is_uploaded_file($tmp_path)) {
        $error['image_path'] = '画像がアップロードされていません';
        return $error;
    }

    $imageType = $image["type"];
    $allowedTypes = array('image/png', 'image/jpeg', 'image/gif');
    if (!in_array($imageType, $allowedTypes)) {
        $error['image_path'] = 'ファイルは画像形式のみアップロードできます';
        return $error;
    }

    // 他のバリデーションチェックでエラーがなければ保存する
    if (empty($validateerror)) {
        $filename = date('YmdHis') . '_' . $imageName;
        $uploadDir = '../../public/image/';

        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $error['image_path'] = 'ディレクトリの作成に失敗しました';
                return $error;
            }
        }

        $savePath = $uploadDir . $filename;

        if (!move_uploaded_file($tmp_path, $savePath)) {
            $error['image_path'] = 'ファイルの保存に失敗しました';
            return $error;
        }
    }
    $_SESSION['savePath'] = $savePath;
    
    return [];
}


/**
 * 画像ファイルのバリデーションを行う
 * @param array $image アップロードされた画像の情報（$_FILESから取得）
 * @return array エラーメッセージの配列
 */
function uploadImage($savePath)
{
    $savePath = $savePath ?? '';
    return $savePath;
}



function setCategoryName($category)
{
    if ($category === 1) {
        return '日常';
    } else if ($category === 2) {
        return 'プログラミン';
    } else {
        var_dump($category);
        return 'その他';
    }
}



?>

