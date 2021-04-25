<?php
/*
 * Comment クラスの model
 */
class Comment
{
  private $db;

  public function __construct(){
    // Databaseクラスのインスタンス化
    $this->db = new Database;
  }

  public function getCommentById($id){
    $this->db->query('SELECT * FROM comments WHERE id = :id');
    $this->db->bind(':id', $id);
    $row = $this->db->single();

    return $row;
  }

  public function getCommentsByArticleId($articleId){
    $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.created_at as commentCreated,
                        users.created_at as userCreated,
                        users.name as userName
                        FROM comments
                        INNER JOIN users
                        ON comments.user_id = users.id
                        WHERE article_id = :article_id
                        ORDER BY comments.created_at DESC
                        ');
    $this->db->bind(':article_id', $articleId);
    
    $result = $this->db->resultGet();
    return $result;
  }

  public function getUserByUserId($userId){
    $this->db->query('SELECT *
                            WHERE user_id = :user_id
                            FROM comments
                            INNER JOIN users
                            ON comments.user_id = users.id
                            ');

    $this->db->bind(':user_id', $userId);
    $row = $this->db->single();

    return $row;
  }

  public function addComment($data){
    $this->db->query('INSERT INTO comments(user_id, article_id, body) VALUE(:user_id, :article_id, :body)');
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':article_id', $data['article_id']);
    $this->db->bind(':body', $data['body']);

    // SQLを実行
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }

  public function updateComment($data){
    $this->db->query('UPDATE comments SET body = :body WHERE id = :id');
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':body', $data['body']);

    // SQLを実行
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }

  public function deleteComment($id){
    $this->db->query('DELETE FROM comments WHERE id = :id');
    $this->db->bind(':id', $id);
    
    // SQLを実行
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }
}