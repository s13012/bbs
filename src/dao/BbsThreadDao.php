<?php
require_once('BaseDao.php');
require_once(dirname(__FILE__) . './../model/BbsThreadList.php');
require_once(dirname(__FILE__) . './../model/BbsResponse.php');
require_once(dirname(__FILE__) . './../model/BbsThread.php');
require_once(dirname(__FILE__) . './../dao/BbsResponseDao.php');

class BbsThreadDao extends BaseDao {

    /**
     * スレッドの一覧を取得する。
     * @return array|null スレッド一覧の情報が入ったBbsThreadListクラスの配列を返す。スレッドが存在しない場合はnullを返す。
     */
    public function getAllThreads() {
        // (スレッドID, スレッドタイトル, レス数, 作成日)を取得するSQL
        $sql = 'SELECT t.id, t.title, COUNT(r.thread_id) "comments", t.creation_date
                FROM thread t LEFT JOIN response r
                ON t.id = r.thread_id
                GROUP BY t.id;';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'BbsThreadList');
    }

    /**
     * $limitで指定された件数分のスレッドを取得する
     * @param $limit int 取得するスレッドの件数
     * @param $offset int 取得するスレッドの開始位置
     * @return array|null スレッド一覧の情報が入ったBbsThreadListクラスの配列を返す。スレッドが存在しない場合はnullを返す。
     */
    public function getThreadInLimit($limit, $offset) {
        $sql = 'SELECT t.id, t.title, COUNT(r.thread_id) "comments", t.creation_date
                FROM thread t LEFT JOIN response r
                ON t.id = r.thread_id
                GROUP BY t.id
                LIMIT :limit OFFSET :offset';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'BbsThreadList');
    }

    /**
     * $titleで指定されたタイトル名でスレッドを新規作成する
     * @param $title string 新規作成するスレッドのタイトル
     * @return BbsThread 追加したスレッドの情報が入ったBbsThreadクラスのインスタントを返す。
     */
    public function insertThreadByTitle($title) {
        $sql = "INSERT INTO thread (title) VALUES (:title)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();
        
        return self::getThreadById($this->pdo->lastInsertId());
    }

    /**
     * @param $id int 取得したいスレッドのID
     * @return BbsThread スレッドの情報が入ったBbsThreadクラスのインスタントを返す
     */
    public function getThreadById($id) {
        $sql = "SELECT * FROM thread WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject('BbsThread');
    }

    /**
     * @return int threadテーブルの総レコード数を返す
     */
    public function getMaxRowCount() {
        $sql = 'SELECT * FROM thread';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
}
