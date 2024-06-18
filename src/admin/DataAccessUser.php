<?php

require_once('../lib/functions.php');
require_once('../config/env.php');

class User
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = preg_replace('/[^a-zA-Z0-9_]/', '', 'user');
    }
    //============================================
    // 1.DBへ接続
    //============================================
    public function UserDbConnect()
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
            error_log('DB接続エラー: ' . $e->getMessage() . ' (DSN: ' . $dsn . ', User: ' . DB_USER . ')');
            throw new Exception('データベース接続に失敗しました: ' . $e->getMessage());
        }
    }

    // //============================================
    // // INSERT文（データ追加）
    // //============================================
    public function UserDbCreate($data)
    {

        $sql = "INSERT INTO $this->table_name (name, tel, email, gender, genre, pref, datetimelocal, image_path, textarea, password, checkbox_name, user_agent, ip_address) VALUES (:name, :tel, :email, :gender, :genre, :pref, :datetimelocal, :image_path, :textarea, :password, :checkbox_name, :user_agent, :ip_address)";

        $dbh = $this->UserDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':tel', $data['tel'], PDO::PARAM_INT);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':gender', $data['gender'], PDO::PARAM_STR);
            $stmt->bindValue(':genre', $data['genre'], PDO::PARAM_STR);
            $stmt->bindValue(':pref', $data['pref'], PDO::PARAM_STR);
            $stmt->bindValue(':datetimelocal', $data['datetimelocal'], PDO::PARAM_STR);
            $stmt->bindValue(':image_path', uploadImage($_SESSION['savePath']) ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':textarea', $data['textarea'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':checkbox_name', $data['checkbox_name'], PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', getUserAgent(), PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', getIpAddress(), PDO::PARAM_STR);
            $stmt->execute();
          
            $_SESSION['message'] = 'ユーザー登録完了しました。';
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = 'このメールアドレスは既に登録されています。';
            } else {
                $_SESSION['error'] = '登録に失敗しました: ' . $e->getMessage();
            }
            error_log('user_form_confirmエラー: ' . $e->getMessage());
        }
    }

    // //============================================
    // // SELECT文（データ取得）
    // //============================================
    public function UserDbRead()
    {
        $dbh = $this->UserDbConnect();
        $sql = "SELECT * FROM $this->table_name";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $result;
    }

    // //============================================
    // // UPDATE文（データ更新）
    // //============================================
    // public function UserDbUpdate($data)
    // {
    //     $sql = "UPDATE $this->table_name SET
    //     name = :name, tel = :tel, email = :email, gender = :gender, pref = :pref, updated_at = :updated_at WHERE id = :id";

    //     $dbh = $this->UserDbConnect();
    //     try {
    //         $stmt = $dbh->prepare($sql);
    //         $stmt->bindValue(':id', $data['id'], \PDO::PARAM_INT);
    //         $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
    //         $stmt->bindValue(':tel', $data['tel'], PDO::PARAM_INT);
    //         $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
    //         $stmt->bindValue(':gender', $data['gender'], PDO::PARAM_STR);
    //         $stmt->bindValue(':pref', $data['pref'], PDO::PARAM_STR);
    //         $stmt->bindValue(':updated_at', $data['updated_at'], PDO::PARAM_STR);
    //         $stmt->execute();
    //         $_SESSION['message'] = 'ユーザー登録完了しました。';
    //         return true;
    //     } catch (PDOException $e) {
    //         if ($e->getCode() == 23000) {
    //             $_SESSION['error'] = 'このメールアドレスは既に登録されています。';
    //         } else {
    //             $_SESSION['error'] = '登録に失敗しました: ' . $e->getMessage();
    //         }
    //         error_log('AdminDbCreateエラー: ' . $e->getMessage());
    //         header('Location: user_form_update.php');
    //         throw new Exception('登録に失敗しました');
    //     }
    // }

    // //============================================
    // // DELETE文（データ削除）
    // //============================================
    public function UserDbDelete($id)
    {
        if (empty($id)) {
            exit('IDが不正です');
        }
        $dbh = $this->UserDbConnect();

        $stmt = $dbh->prepare("DELETE FROM $this->table_name where id = :id Limit 1");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            error_log('UserDbDeleteエラー: ' . $e->getMessage());
            throw new Exception('データ削除に失敗しました');
        }
    }

    // //============================================
    // // SELECT文（データ詳細）
    // //============================================
    public function UserDbDetail($id)
    {
        if (empty($id)) {
            throw new Exception('IDが不正です');
        }

        $dbh = $this->UserDbConnect();
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $dbh = null;
        if (!$result) {
            throw new Exception('データが見つかりません');
        }
        return $result;
    }

    public function UserDbSearch($data)
    {
        $sql = "SELECT * FROM $this->table_name WHERE name LIKE :keyword";
        $dbh = $this->UserDbConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $data['keyword'] . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('UserDbSearchエラー: ' . $e->getMessage());
            throw new Exception('データの検索に失敗しました');
        }
    }

    // public function UserDbDetailImage()
    // {
        
    //     $sql = "SELECT image_path FROM $this->table_name ORDER BY created_at DESC LIMIT 1;";
    //     $dbh = $this->UserDbConnect();
    //     $stmt = $dbh->prepare($sql);
    //     $stmt->execute();
    //     $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    //     $dbh = null;
    //     if (!$result) {
    //         throw new Exception('データが見つかりません');
    //     }
    //     return $result;
    // }

    // /**
    //  * ファイルデータを保存
    //  * @param string $filename ファイル名
    //  * @param string $save_path 保存先のパス
    //  * @param string $caption 投稿の説明
    //  * @param bool $result
    //  */
    // function fileSave($filename, $save_path, $caption)
    // {
    //     $result = False;

    //     $sql = "INSERT INTO file(file_name, file_path, description) VALUES (?, ?, ?)";

    //     try {
    //         $stmt = $this->UserDbConnect->prepare($sql);
    //         $stmt->bindValue(1, $filename);
    //         $stmt->bindValue(2, $save_path);
    //         $stmt->bindValue(3, $caption);
    //         //(execute)SQLを実行し結果を$resultに格納
    //         $result = $stmt->execute();
    //         return $result;
    //     } catch (\Exception $e) {
    //         echo $e->getMessage();
    //         return $result;
    //     }
    // }

    // /**
    //  * ファイルデータを取得
    //  * @return array $fileData
    //  */
    // function getAllFile()
    // {

    //     $sql = "SELECT * FROM file ORDER BY id DESC";
    //     $fileData = $this->UserDbConnect->query($sql);
    //     return $fileData;
    // }
}
