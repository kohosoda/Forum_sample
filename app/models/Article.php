<?php
/*
 * Article クラスの model
 */
class Article
{
  private $db;

  public function __construct(){
    // Databaseクラスのインスタンスを作成
    $this->db = new Database;
  }

  public function getArticles(){
    $this->db->query('SELECT *,
                        articles.id as articleId,
                        users.id as userId,
                        articles.created_at as articleCreated,
                        users.created_at as userCreated
                        From articles
                        INNER JOIN users
                        ON articles.user_id = users.id
                        ORDER BY articles.created_at DESC
                        ');
                        
    $results = $this->db->resultGet();

    return $results;
  }

  public function getArticleById($id){
    $this->db->query('SELECT * FROM articles WHERE id = :id');
    $this->db->bind(':id', $id);
    $row = $this->db->single();

    return $row;
  }

  public function addArticle($data){
    $this->db->query('INSERT INTO articles(title, user_id, body) VALUES(:title, :user_id, :body)');
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':body', $data['body']);

    // SQLを実行して、結果(true/false)を返す
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }

  public function updateArticle($data){
    $this->db->query('UPDATE articles SET title = :title, body = :body WHERE id = :id');
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);
    $this->db->bind(':id', $data['id']);

    // SQLを実行して、結果(true/false)を返す
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }

  public function deleteArticle($id){
    $this->db->query('DELETE FROM articles WHERE id = :id');
    $this->db->bind(':id', $id);

    // SQLを実行して、結果(true/false)を返す
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }
}