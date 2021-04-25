<?php
class Comments extends Controller
{
  public function __construct()
  {
    // モデルのインスタンス化
    $this->articleModel = $this->model('Article');
    $this->userModel = $this->model('User');
    $this->commentModel = $this->model('Comment');
  }

  public function add($articleId)
  {
    $article = $this->articleModel->getArticleById($articleId);
    $user = $this->userModel->getUserById($article->user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // POSTメソッドの場合
      // サニタイズ
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'article_id' => $articleId,
        'user_id' => $user->id,
        'body' => trim($_POST['body']),
        'body_err' => '',
      ];

      // バリデーション
      if (empty($data['body'])) {
        $data['body_err'] = 'コメントを入力してください';
      }

      // エラーが空かどうかを確認する
      if (empty($data['body_err'])) {
        if ($this->commentModel->addComment($data)) {
          flash('comment_message', 'コメントが追加されました');
          redirect('articles/show/' . $articleId);
        } else {
          die('Something went wrong');
        }
      } else {
        // エラーがある場合はページを返す
        $this->view('comments/add', $data);
      }
    } else {
      // GEtメソッドの場合

      $data = [
        'article' => $article,
        'user' => $user,
        'body' => '',
      ];

      $this->view('comments/add', $data);
    }
  }

  public function edit($id)
  {
    $comment = $this->commentModel->getCommentById($id);
    $article = $this->articleModel->getArticleById($comment->article_id);
    $user = $this->userModel->getUserById($comment->user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // POSTメソッドの場合
      // サニタイズ
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'id' => $id,
        'user_id' => $comment->user_id,
        'article_id' => $comment->article_id,
        'body' => trim($_POST['body']),
        'body_err' => '',
        'article' => $article,
        'user' => $user,
      ];

      // バリデーション
      if (empty($data['body'])) {
        $data['body_err'] = 'コメントを入力してください';
      }

      // エラーが空かどうかを確認する
      if (empty($data['body_err'])) {
        if ($this->commentModel->updateComment($data)) {
          flash('comment_message', 'コメントが更新されました');
          redirect('articles/show/' . $comment->article_id);
        } else {
          die('Something went wrong');
        }
      } else {
        // エラーがある場合はページを返す
        $this->view('comments/edit', $data);
      }
    } else {
      // GETメソッドの場合

      // ログインユーザーが投稿ユーザーと合致するか確認
      if ($comment->user_id !== $_SESSION['user_id']) {
        redirect('articles/show/' . $comment->article_id);
      }

      $data = [
        'id' => $id,
        'body' => $comment->body,
        'article' => $article,
        'user' => $user,
      ];

      $this->view('comments/edit', $data);
    }
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $comment = $this->commentModel->getCommentById($id);
      // var_dump($comment);
      // exit;
      
      // ログインユーザーが投稿ユーザーと合致するか確認
      if($comment->user_id !== $_SESSION['user_id']) {
        redirect('articles/show/' . $comment->article_id);
      }

      // 削除処理を実行
      if($this->commentModel->deleteComment($id)){
        flash('comment_message', 'コメントが削除されました');
        redirect('articles/show/' . $comment->article_id);
      } else {
        die('Something went wrong');
      }
    }
  }
}
