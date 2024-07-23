<?php
// session_start();
require_once('../lib/functions.php');
require_once('../config/env.php');

class Admin
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = preg_replace('/[^a-zA-Z0-9_]/', '', 'admin');
    }
    //============================================
    // 1.DBへ接続
    //============================================
    public function AdminDbConnect()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        try {
            $dbh = new PDO($dsn, DB_USER, DB_PASS,  [
                //エラーのモードを決める
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //配列をキーと値で返す
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // PDOのエミュレート機能を無効
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $dbh;
        } catch (PDOException $e) {
            error_log('DB接続エラー: ' . $e->getMessage());
            throw new Exception('データベース接続に失敗しました');
        }
    }

    //============================================
    // WHERE文（ログイン認証、メールアドレス）
    //============================================
    private function authenticateUser($email, $password)
    {

        $sql = "SELECT * FROM $this->table_name WHERE email = :email";
        $dbh = $this->AdminDbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
    }

    //============================================
    // WHERE文（ログイン認証）
    //============================================
    public function AdminDbLogin($data)
    {
        try {
            $admin = $this->authenticateUser($data['email'], $data['password']);

            if (!$admin) {
                $_SESSION['error'] = 'メールアドレスまたはパスワードが正しくありません';
                return false;
            }

            if ($admin['deleted_at']) {
                $_SESSION['error'] = '退会済みです';
                return false;
            }

            // ログイン成功時に最終ログイン日時を更新する
            $sql_update = "UPDATE $this->table_name SET last_login = :last_login WHERE id = :id";
            $dbh = $this->AdminDbConnect();
            $stmt_update = $dbh->prepare($sql_update);
            $stmt_update->bindValue(':last_login', getDateTime(), PDO::PARAM_STR);
            $stmt_update->bindValue(':id', $admin['id'], PDO::PARAM_INT);
            $stmt_update->execute();

            // セッションにユーザー情報を保存
            $_SESSION['id'] = $admin['id'];
            $_SESSION['name'] = $admin['name'];

            return true;
        } catch (Exception $e) {
            error_log('Loginエラー: ' . $e->getMessage());
            $_SESSION['error'] = 'ログイン認証に失敗しました';
            return false;
        }
    }

    //============================================
    // UPDATE文（退会日時更新）
    //============================================
    public function AdminDbUpdateDeleted($data)
    {

        try {
            $admin = $this->authenticateUser($data['email'], $data['password']);

            // ログイン者の情報しか退会できません
            if ($data['id'] !== $admin['id']) {
                $_SESSION['error'] = '他の人の情報は削除できません';
                return false;
            }

            if (!$admin) {
                $_SESSION['error'] = 'メールアドレスまたはパスワードが正しくありません';
                return false;
            }

            // 成功時に削除日時を更新する
            $sql_update = "UPDATE $this->table_name SET deleted_at = :deleted_at WHERE id = :id";
            $dbh = $this->AdminDbConnect();
            $stmt_update = $dbh->prepare($sql_update);
            $stmt_update->bindValue(':deleted_at', getDateTime(), PDO::PARAM_STR);
            $stmt_update->bindValue(':id', $admin['id'], PDO::PARAM_INT);
            $stmt_update->execute();
            return true;
        } catch (Exception $e) {
            error_log('削除処理エラー: ' . $e->getMessage());
            $_SESSION['error'] = '退会処理に失敗しました';
            return false;
        }
    }

    //============================================
    // INSERT文（データ追加）
    //============================================
    public function AdminDbCreate($data)
    {
        $sql = "INSERT INTO $this->table_name (name, email, password, user_agent, ip_address) VALUES (:name, :email, :password, :user_agent, :ip_address)";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', getUserAgent(), PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', getIpAddress(), PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'メールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbCreateエラー: ' . $e->getMessage());
        }
    }

    //============================================
    // UPDATE文（会員情報変更）
    //============================================
    public function AdminDbUpdate($data)
    {
        $sql = "UPDATE $this->table_name SET
        name = :name, email = :email, updated_at = :updated_at WHERE id = :id";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', getDateTime(), PDO::PARAM_STR);
            $stmt->execute();
            // $_SESSION['message'] = 'ユーザー登録更新完了しました。';
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbCreateエラー: ' . $e->getMessage());
        }
    }

    //============================================
    // SELECT文（データ詳細）
    //============================================
    public function AdminDbDetail($id)
    {
        if (empty($id)) {
            throw new Exception('IDが不正です');
        }

        $dbh = $this->AdminDbConnect();
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id Limit 1");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $dbh = null;
        if (!$result) {
            throw new Exception('データが見つかりません');
        }
        return $result;
    }

    //============================================
    // ログアウト処理
    //============================================
    public function AdminDblogout()
    {
        session_unset();
        session_destroy();
        header('Location: admin_signin.php');
        exit();
    }

    //============================================
    // パスワード再設定手続き
    //============================================
    public function AdminDbPassReset($email)
    {

        $sql = "SELECT * FROM $this->table_name WHERE email = :email";
        $dbh = $this->AdminDbConnect();

        try {

            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            // メールアドレスに一致するエントリがあるかどうかを確認
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "UPDATE $this->table_name SET
            password_reset_requested_at = :password_reset_requested_at  WHERE id = :id";

            // パスワード再手続き依頼日時の処理
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $result['id'], PDO::PARAM_INT);
            $stmt->bindValue(':password_reset_requested_at', getDateTime(), PDO::PARAM_STR);
            $stmt->execute();

            // 退会日時が登録されていれば、falseを返す
            if ($result['deleted_at']) {
                return false;
            } else {

                return $result;
            }
        } catch (Exception $e) {
            error_log('AdminDbPassResetエラー: ' . $e->getMessage());
            throw new Exception('登録に失敗しました');
        }
    }

    /**
     * パスワード再登録メール送信
     *
     * @param string $email メール送信先のメールアドレス
     * @param string $token トークン（パスワードリセット用の一意の識別子）
     * @param int $expiry 有効期限（秒単位での期限、例えば900秒＝15分）
     * @return bool 送信が成功した場合はtrue、失敗した場合はfalse
     */
    public function AdminDbEmail($email)
    {
        // 日本語のメール送信のための設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $_SESSION['email'] = $email;

        // 有効期限（秒単位、ここでは900秒＝15分）
        $expiry = 900;

        // パスワードリセット用のUR
        $url = "https://trippleblog0942.com/src/admin/admin_password_update.php";

        // メールの件名
        $subject =  'パスワードリセット用URLをお送りします';

        // メール本文
        $body = <<<EOD
        本メールは、パスワードの再登録手続きをされたことを確認するためにお送りしています。
        パスワードの再登録を希望される場合は、以下のURLにアクセスし、パスワードの変更を行ってください。

        ■パスワードの再登録ページURL
        {$url}
        ※本メールは通知専用メールで返ができません。
        ※有効期限は{$expiry}秒です。
        EOD;

        // From ヘッダーの設定（実際のドメイン名や送信元のアドレスに修正が必要です）
        $from = "From: trippleblog0942.com";

        // Content-Type ヘッダーの設定
        $headers = "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= $from;

        // メール送信
        $isSent = mb_send_mail($email, $subject, $body, $headers);
        return $isSent;
    }

    //============================================
    // UPDATE文（パスワード変更）
    //============================================
    public function AdminDbPasswordUpdate($data)
    {
        $sql = "UPDATE $this->table_name SET
        password = :password, password_changed_at = :password_changed_at WHERE email = :email";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_INT);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':password_changed_at', getDateTime(), PDO::PARAM_STR);

            // SQLを実行し、結果を確認する
            $result = $stmt->execute();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbPasswordUpdateエラー: ' . $e->getMessage());
            return false;
        }
    }
}
