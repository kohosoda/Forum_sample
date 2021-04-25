<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  // ユーザー登録
  public function register()
  {
    // POST メソッドの場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // フォームの値を処理する
      // POSTリクエストをサニタイズする
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // dataを初期化
      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      // nameのバリデーション
      if (empty($data['name'])) {
        $data['name_err'] = '名前を入力してください';
      }

      // emailのバリデーション
      if (empty($data['email'])) {
        $data['email_err'] = 'メールアドレスを入力してください';
      } else {
        // emailの重複をチェック
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = '登録済みのアカウントです';
        }
      }

      // passwordのバリデーション
      if (empty($data['password'])) {
        $data['password_err'] = 'パスワードを入力してください';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = '6文字以上で入力してください';
      }

      // confirm_passwordのバリデーション
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'パスワード(確認用)を入力してください';
      } else {
        if ($data['password'] !== $data['confirm_password']) {
          $data['confirm_password_err'] = 'パスワードが合致しません';
        }
      }

      // エラーが空かどうかを確認
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // バリデーションに成功
        // パスワードをハッシュ化
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Userを登録する
        if ($this->userModel->register($data)) {
          flash('register_success', '登録が完了しました。ログインができます。');
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
      } else {
        // エラーメッセージとともにページを返す
        $this->view('users/register', $data);
      }
    } else {
      // GETメソッドの場合
      // dataを初期化
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      // viewを読み込む
      $this->view('users/register', $data);
    }
  }

  // ログイン
  public function login()
  {
    // POST メソッドの場合      
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // フォームの値を処理する
      // POSTリクエストをサニタイズする
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // dataの初期化
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
      ];

      // emailのバリデーション
      if (empty($data['email'])) {
        $data['email_err'] = 'メールアドレスを入力してください';
      }

      // passwordのバリデーション
      if (empty($data['password'])) {
        $data['password_err'] = 'パスワードを入力してください';
      }

      // emailが登録済みかどうかを確認する
      if(!$this->userModel->findUserByEmail($data['email'])){
        $data['email_err'] = 'ユーザーが見つかりません';
      }

      // エラーが空かどうかを確認する
      if (empty($data['email_err']) && empty($data['password_err']) ) {
        // ログイン認証を行う。成功した場合にはuserのレコードが取得できる。
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if($loggedInUser){
          // セッションを作成する
          $this->createUserSession($loggedInUser);
        } else {
          // 認証に失敗した場合、エラーメッセージとともにページを返す
          $data['password_err'] = 'パスワードを確認して再度ログインを実施してください';
          $this->view('users/login', $data);
        }

        redirect('articles/index');
      } else {
        // エラーメッセージとともにページを返す
        $this->view('users/login', $data);
      }
      
    } else {
      // GET メソッドの場合
      // dataを初期化
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      // viewを読み込む
      $this->view('users/login', $data);
    }
  }

  // ユーザー用にセッションを作成
  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('pages/index');
  }

  // ログアウト
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    redirect('users/login');
  }
}
