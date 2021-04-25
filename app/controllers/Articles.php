<?php
  class Articles extends COntroller
  {
    public function __construct(){
      // モデルのインスタンス化
      $this->articleModel = $this->model('Article');
      $this->userModel = $this->model('User');
      $this->commentModel = $this->model('Comment');
    }

    public function index(){
      // Articlesを取得する
      $articles = $this->articleModel->getArticles();

      $data = [
        'articles' => $articles,
      ];

      $this->view('articles/index', $data);
    }

    public function show($id){
      $article = $this->articleModel->getArticleById($id);
      $user = $this->userModel->getUserById($article->user_id);
      $comments = $this->commentModel->getCommentsByArticleId($id);
      // var_dump($comments);
      // exit;

      $data = [
        'article' => $article,
        'user' => $user,
        'comments' => $comments,
      ];

      // var_dump($data);
      $this->view('articles/show', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
      // POSTメソッドの場合
        // サニタイズ
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => '',
        ];

        // バリデーション
        if(empty($data['title'])){
          $data['title_err'] = 'タイトルを入力してください';
        }
        if(empty($data['body'])){
          $data['body_err'] = '投稿内容を入力してください';
        }

        // エラーが空かどうかを確認する
        if(empty($data['title_err']) && empty($data['body_err'])){
           if($this->articleModel->addArticle($data)){
            flash('article_message', '投稿が追加されました');
            redirect('articles');
           } else {
             die('Something went wrong');
           }
        } else {
          // エラーメッセージとともにページを返す
          $this->view('articles/add', $data);
        }

      } else {
      // GETメソッドの場合
        $data = [
          'title' => '',
          'body' => '',
        ];

        $this->view('articles/add', $data);
      }
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
      // POSTメソッドの場合
      // サニタイズ
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => '',
        ];

        // バリデーション
        if(empty($data['title'])){
          $data['title_err'] = 'タイトルを入力してください';
        }
        if(empty($data['body'])){
          $data['body_err'] = '投稿内容を入力してください';
        }
        
        // エラーが空かどうかを確認する
        if(empty($data['title_err']) && empty($data['body_err'])){
          if($this->articleModel->updateArticle($data)){
           flash('article_message', '投稿が更新されました');
           redirect('articles');
          } else {
            die('Something went wrong');
          }
       } else {
         // エラーメッセージとともにページを返す
         $this->view('articles/edit', $data);
       }
       
       
      } else {
      // GETメソッドの場合
        // 対象の投稿を取得する
        $article = $this->articleModel->getArticleById($id);

        // ログインユーザーが投稿ユーザーと合致するか確認
        if($article->user_id !== $_SESSION['user_id']){
          redirect('articles');
        }

        $data = [
          'id' => $id,
          'title' => $article->title,
          'body' => $article->body,
        ];

        $this->view('articles/edit', $data);
      }
    }
    
    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
      // POSTメソッドの場合
        // 対象の投稿を取得する
        $article = $this->articleModel->getArticleById($id);

        // ログインユーザーが投稿ユーザーと合致するか確認
        if($article->user_id !== $_SESSION['user_id']){
          redirect('articles');
        }

        if($this->articleModel->deleteArticle($id)){
          flash('article_message', '投稿は削除されました');
          redirect('articles');
        } else {
          die('Something went wrong');
        }
      }
    }
  }