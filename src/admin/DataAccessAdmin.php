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

    /**
     * データベースに接続します。
     *
     * @return PDO データベース接続オブジェクト
     * @throws Exception データベース接続に失敗した場合
     */
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

    /**
     * メールアドレスとパスワードを使用してユーザーを認証します。
     *
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @return array|false 認証されたユーザー情報。認証に失敗した場合はfalseを返す。
     */
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
        return false;
    }

    /**
     * ログイン処理を行います。
     *
     * @param array $data メールアドレスとパスワードを含む連想配列
     * @return bool ログイン成功ならtrue、失敗ならfalse
     */
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

    /**
     * ユーザーの退会日時を更新します。
     *
     * @param array $data メールアドレス、パスワード、ユーザーIDを含む連想配列
     * @return bool 退会処理が成功した場合はtrue、失敗した場合はfalse
     */
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

    /**
     * 新しいユーザーをデータベースに追加します。
     *
     * @param array $data ユーザーの名前、メールアドレス、パスワード、ユーザーエージェント、IPアドレスを含む連想配列
     * @return bool データ追加が成功した場合はtrue、失敗した場合はfalse
     */
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

    /**
     * ユーザーの情報を更新します。
     *
     * @param array $data 更新するユーザーの情報（ID、名前、メールアドレス）を含む連想配列
     * @return bool 更新が成功した場合はtrue、失敗した場合はfalse
     */
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
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbUpdateエラー: ' . $e->getMessage());
        }
    }

    /**
     * 特定のユーザーの詳細情報を取得します。
     *
     * @param int $id ユーザーのID
     * @return array ユーザーの詳細情報
     * @throws Exception IDが不正またはデータが見つからない場合
     */
    public function AdminDbDetail($id)
    {
        if (empty($id)) {
            throw new Exception('IDが不正です');
            header('Location: admin_top.php');
        }

        $dbh = $this->AdminDbConnect();
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id Limit 1");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $dbh = null;
        if (!$result) {
            header("Location: admin_signin.php");
            throw new Exception('データが見つかりません');
        }
        return $result;
    }

    /**
     * パスワードリセットのトークンを生成し、データベースに保存します。
     *
     * @param string $email メールアドレス
     * @return string|false トークンを返す。メールアドレスが存在しない場合はfalseを返す
     * @throws Exception パスワードリセット処理に失敗した場合
     */
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

            // 退会日時が登録されていれば、falseを返す
            // if ($result['deleted_at']) {
            //     return false;
            // } else {
            //     return $result;
            // }

            if ($result) {
                // トークンの生成
                $token = bin2hex(random_bytes(32));
                $expiry = date('Y-m-d H:i:s', time() + 900); // 15分後のタイムスタンプ

                // パスワードリセットのトークンと有効期限を更新
                $sql = "UPDATE $this->table_name SET 
                password_reset_requested_at = :password_reset_requested_at, 
                token = :token, 
                expiry = :expiry 
                WHERE email = :email";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password_reset_requested_at', getDateTime(), PDO::PARAM_STR);
                $stmt->bindValue(':token', $token, PDO::PARAM_STR);
                $stmt->bindValue(':expiry', $expiry, PDO::PARAM_STR);
                $stmt->execute();

                return $token;
            } else {
                return false; // メールアドレスが存在しない
            }
        } catch (PDOException $e) {
            error_log('AdminDbPassResetエラー: ' . $e->getMessage());
            throw new Exception('パスワードリセット処理に失敗しました');
        }
    }

    /**
     * パスワードリセット用のメールを送信します。
     *
     * @param string $email メール送信先のメールアドレス
     * @param string $token トークン（パスワードリセット用の一意の識別子）
     * @param int $expiry 有効期限（秒単位での期限、例えば900秒＝15分）
     * @return bool 送信が成功した場合はtrue、失敗した場合はfalse
     */
    public function sendPasswordResetEmail($email, $token, $expiry)
    {
        // 日本語のメール送信のための設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        // パスワードリセット用のURL
        $url = "https://trippleblog0942.com/src/admin/admin_password_update.php?token={$token}";

        // 有効期限を分単位で計算
        $expiry_minutes = $expiry / 60;

        // メールの件名
        $subject =  'パスワードリセット用URLをお送りします';

        // メール本文
        $body = "本メールは、パスワードの再登録手続きをされたことを確認するためにお送りしています。
        パスワードの再登録を希望される場合は、以下のURLにアクセスし、パスワードの変更を行ってください。

        ■パスワードの再登録ページURL
        {$url}
        ※本メールは通知専用メールで返信ができません。
        ※有効期限は{$expiry_minutes} 分です。";

        // From ヘッダーの設定（実際のドメイン名や送信元のアドレスに修正が必要です）
        $from = "From: no-reply@trippleblog0942.com";

        // Content-Type ヘッダーの設定
        $headers = "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= $from;

        // メール送信
        $isSent = mb_send_mail($email, $subject, $body, $headers);
        return $isSent;
    }

    /**
     * トークンの検証を行います。
     *
     * @param string $token パスワードリセットトークン
     * @return bool トークンが有効な場合はtrue、無効な場合はfalse
     */
    private function verifyResetToken($token)
    {
        $sql = "SELECT COUNT(*) FROM $this->table_name WHERE token = :token AND expiry > NOW()";
        $dbh = $this->AdminDbConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log('verifyResetTokenエラー: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * パスワードを更新します。
     *
     * @param array $data 更新するパスワードを含む連想配列
     * @param string $url_token パスワードリセットトークン
     * @return bool 更新が成功した場合はtrue、失敗した場合はfalse
     */
    public function AdminDbPasswordUpdate($data, $url_token)
    {

        // トークンを検証
        if (!$this->verifyResetToken($url_token)) {
            return false; // トークンが無効な場合
        }

        $sql = "SELECT * FROM $this->table_name WHERE token = :token";
        $dbh = $this->AdminDbConnect();

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $url_token, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch();

        if (!$admin) {
            return false; // トークンに一致するレコードが存在しない場合
        }

        // トークンに一致するメールアドレスを取得
        $email = $admin['email'];

        // トークンが有効な場合はパスワードを更新
        $sql = "UPDATE $this->table_name SET
        password = :password, 
        password_changed_at = :password_changed_at,
        token = NULL, 
        expiry = NULL
        WHERE token = :token";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':token', $url_token, PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':password_changed_at', getDateTime(), PDO::PARAM_STR);

            // SQLを実行し、結果を確認する
            $result = $stmt->execute();

            if ($result) {
                // パスワード変更通知の送信
                $this->sendPasswordChangeEmail($email);
            }

            return $result;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'パスワードの更新に失敗しました: ' . $e->getMessage();
            error_log('AdminDbPasswordUpdateエラー: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * パスワード再設定の成功を通知するメールを送信します。
     *
     * @param string $email メール送信先のメールアドレス
     * @return bool 送信が成功した場合はtrue、失敗した場合はfalse
     */
    public function sendPasswordChangeEmail($email)
    {
        // 日本語のメール送信のための設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        // メールの件名
        $subject = "パスワード変更のお知らせ";

        // メール本文
        $message = "こんにちは、\n\nあなたのパスワードが変更されました。\n\nもしこの変更を行っていない場合は、直ちにサポートに連絡してください。";

        // From ヘッダーの設定
        $from = "From: no-reply@trippleblog0942.com";

        // Content-Type ヘッダーの設定
        $headers = "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= $from;

        // メール送信
        $isSent = mb_send_mail($email, $subject, $message, $headers);
        return $isSent;
    }
}
