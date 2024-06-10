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
 * 文字列をHTML特殊文字に変換（サニタイズ処理）
 *
 * @param string $str 変換する文字列
 * @return string 変換された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF対策
 * @param void
 * return string $csrf_token
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
 * IPアドレス取得
 * @param
 * return string $$ip
 */
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IPアドレスは共有インターネット接続から取得された
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IPアドレスはプロキシサーバーを経由して取得された
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IPアドレスはリモートアドレスから取得された
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * ユーザーエージェント取得
 * @param
 * return string $$ip
 */
function getUserAgent()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    return $userAgent;
}

?>
<?php
/*
    引数のバリデーション処理を実行する
    引数：任意のバリデーションパラメータ
    戻り値：数字・記号・アルファベット(32 bytes)の文字列であればその文字列、そうでなければ空文字列
*/


function validateLogin($data)
{
    $error = [];
    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    }
    if (empty($data['password'])) {
        $error['password'] = 'パスワードを入力してください。';
    }
    return $error;
}

function validateUserSignupFormData($data)
{
    $error = [];

    // メールアドレスの取得
    $email = isset($data['email']) ? $data['email'] : '';
    // 確認用メールアドレスの取得
    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';

    // パスワードを取得
    $password = isset($data['password']) ? $data['password'] : '';
    // 確認用パスワードの取得
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    // 名前のバリデーション
    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    } elseif (!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email'])) {
        $error['email'] = "「メールアドレス」は正しい形式で入力してください。";
    }

    // メールアドレスのバリデーション
    if (empty($email)) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $email) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

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



function validateInputFormData($data)
{
    $error = [];

    // メールアドレスの取得
    $email = isset($data['email']) ? $data['email'] : '';
    // 確認用メールアドレスの取得
    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';

    $gender = isset($data['gender']) ? $data['gender'] : '';
    $pref = isset($data['pref']) ? $data['pref'] : '';
    // パスワードを取得
    $password = isset($data['password']) ? $data['password'] : '';
    // 確認用パスワードの取得
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    // 名前のバリデーション
    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    // 電話番号のバリデーション
    if (empty($data['tel'])) {
        $error['tel'] = '電話番号を入力してください。';
    } else if (!preg_match('/^[0][0-9]{9,10}$/', str_replace('-', '', $data['tel']))) {
        $error['tel'] = '電話番号を正しく入力してください。';
    }

    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    } elseif (!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email'])) {
        $error['email'] = "「メールアドレス」は正しい形式で入力してください。";
    }

    // メールアドレスのバリデーション
    if (empty($email)) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $email) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    // 性別のバリデーション
    if (empty($data['gender'])) {
        $error['gender'] = '性別を選択してください';
    }

    // 都道府県のバリデーション
    if (empty($pref)) {
        $error['pref'] = '都道府県を選択してください';
    }

    // if (empty($password)) {
    //     $error['password'] = 'パスワードを入力してください。';
    // } elseif (strlen($password) < 8 || strlen($password) > 16) {
    //     $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    // } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
    //     $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    // } elseif (empty($password_confirm)) {
    //     $error['password_confirm'] = '確認用パスワードを入力してください。';
    // } elseif ($password !== $password_confirm) {
    //     $error['password_confirm'] = 'パスワードが一致しません。';
    // }
    return $error;
}


/*
    引数のバリデーション処理を実行する
    引数：任意のバリデーションパラメータ
    戻り値：数字・記号・アルファベット(16 bytes)の文字列であればその文字列、そうでなければ空文字列
*/
function validateStaffID($param)
{
    // 引数がstring型であることを検証
    if (!is_string($param)) {
        return "";
    }

    // 文字数が32文字以下であることを検証
    if (strlen($param) > 32) {
        return "";
    }

    // 半角数字、記号、アルファベットで構成されているかを検証
    if (!preg_match('/^[a-zA-Z0-9!-\/:-@\[-`\{-~]+$/', $param)) {
        return "";
    }

    // すべての検証を通過した場合はtrueを返す
    return $param;
}
