<?php
/*
 * User クラスの model
 */

class User
{
  private $db;

  public function __construct(){
    // Databaseクラスのインスタンスを作成
    $this->db = new Database;
  }

  // ユーザー登録
  public function register($data){
    $this->db->query('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)');
    // パラメータをbindする
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);

    // SQLを実行してboolean値を返す
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }

  // ログイン
  public function login($email, $password){
    // ユーザーを検索してレコードを取得する
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);
    $row = $this->db->single();

    // パスワードを確認して照合結果を返す
    $hashed_password = $row->password;
    if(password_verify($password, $hashed_password)){
      return $row; // 成功の場合レコードを返す
    } else {
      return false;
    }
  }

  // emailでユーザーを検索して、結果(true/false)を返す
  public function findUserByEmail($email){
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);
    $row = $this->db->single();

    if($this->db->rowCount() > 0){
      return true;
    } else {
      return false;
    }
  }

  // id でユーザーを特定してレコードを返す
  public function getUserById($id){
    $this->db->query('SELECT * FROM users WHERE id = :id');
    $this->db->bind(':id', $id);
    $row = $this->db->single();

    return $row;
  }
}
