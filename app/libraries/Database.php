<?php
/*
 * Databaseクラス
 * 1. PDOを利用してDB接続
 * 2. prepared statement を作成
 * 3. パラメータをbindする
 * 4. レコードやSQL実行結果を返す
 */
class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct(){
    // DSNを設定
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    // オプションを設定
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    // PDOインスタンスを作成
    try{
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOEXception $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // prepare statement を作成するメソッド
  public function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  // Bind values するメソッド
  public function bind($param, $value, $type = null){
    // パラメータの型を判別して、$typeに指定する型を決定する
    if(is_null($type)){
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  // prepared statement を実行するメソッド
  public function execute(){
    return $this->stmt->execute();
  }

  // Objectの配列として結果を得るメソッド
  public function resultGet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // 1行だけレコードを取得するメソッド
  public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // ヒットするレコード数を取得するメソッド
  public function rowCount(){
    return $this->stmt->rowCount();
  }
}