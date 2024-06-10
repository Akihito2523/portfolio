<?php

require_once('../config/env.php');

class Dbc
{
    protected $table_name = 'form';

    //============================================
    // 1.DBへ接続
    //============================================
    public function dbConnect()
    {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $password = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $dbh = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            //echo 'DBの接続成功';
            return $dbh;
        } catch (PDOException $e) {
            error_log('DB接続失敗: ' . $e->getMessage());
            echo 'DBの接続失敗' . $e->getMessage();
            throw new Exception('データベース接続に失敗しました');
        };
    }


    // //============================================
    // // INSERT文（データ追加）
    // //============================================
    public function Create($data)
    {
        $sql = "INSERT INTO $this->table_name(title, content, category,  publish_status) VALUES(:title, :content, :category, :publish_status)";

        $dbh = $this->dbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindValue(':category', $data['category'], PDO::PARAM_INT);
            $stmt->bindValue(':publish_status', $data['publish_status'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            echo 'データを作成しました';
        } catch (PDOException $e) {
            error_log('Createエラー: ' . $e->getMessage());
            throw new Exception('データの作成に失敗しました');
            exit($e);
        }
    }

    // //============================================
    // // SELECT文（データ取得）
    // //============================================
    public function Read()
    {
        $dbh = $this->dbConnect();
        $sql = "SELECT * FROM $this->table_name";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $result;
    }

    // //============================================
    // // UPDATE文（データ更新）
    // //============================================
    public function Update($data)
    {
        $sql = "UPDATE $this->table_name SET
        name = :name, content = :content, category = :category,  publish_status = :publish_status WHERE id = :id";

        $dbh = $this->dbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            // $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            // $stmt->bindValue(':category', $data['category'], PDO::PARAM_INT);
            // $stmt->bindValue(':publish_status', $data['publish_status'], PDO::PARAM_INT);
            // $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            error_log('Updateエラー: ' . $e->getMessage());
        }
    }

    // //============================================
    // // DELETE文（データ削除）
    // //============================================
    public function Delete($id)
    {
        if (empty($id)) {
            exit('IDが不正です');
        }
        $dbh = $this->DbConnect();

        //SQL準備
        $stmt = $dbh->prepare("DELETE FROM $this->table_name where id = :id Limit 1");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
    }

    // //============================================
    // // SELECT文（データ詳細）
    // //============================================
    public function Detail($id)
    {
        if (empty($id)) {
            throw new Exception('IDが不正です');
        }

        $dbh = $this->dbConnect();

        //SQL準備
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);

        //SQL実行
        $stmt->execute();
        //結果を表示
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $dbh = null;
        if (!$result) {
            throw new Exception('データが見つかりません');
        }
        return $result;
    }

    public function Search($data)
    {
        $sql = "SELECT * FROM $this->table_name WHERE name LIKE :keyword";
        $dbh = $this->dbConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $data['keyword'] . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Searchエラー: ' . $e->getMessage());
            exit();
        }
    }

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
    //         $stmt = $this->dbConnect()->prepare($sql);
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
    //     $fileData = $this->dbConnect()->query($sql);
    //     return $fileData;
    // }
}
