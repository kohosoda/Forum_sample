<?php
/*
 * Coreクラス
 * 1. URLの形式 - /controller/method/params から、配列 [controller, method, params] を作成する
 * 2. controllerクラスのインスタンス化
 * 3. controllerクラスのmethodを実行させる (paramsを引数とする)
 */
class Core
{
  // 変数（Controller, Method, params）を初期化
  protected $currentController ='Articles';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct()
  {
    // Coreクラス内のgetUrlメソッドを実行
    $url = $this->getUrl();

    // Controller名を取り出す
    if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
      $this->currentController = ucwords($url[0]);
      unset($url[0]);
    }
    // Controllerクラスをインスタンス化
    require_once '../app/controllers/' . $this->currentController . '.php';
    $this->currentController = new $this->currentController;

    // Method名を取り出す
    if(isset($url[1])){
      if(method_exists($this->currentController, $url[1])){
        $this->currentMethod = $url[1];
        unset($url[1]);
      }
    }

    // Paramsを取り出す
    $this->params = $url ? array_values($url) : [];

    // パラメータを渡して、Controller内のMethodを実行する
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  // "controller/method/params" を配列[controller, method, params]に変換するメソッド
  public function getUrl()
  {
    if(isset($_GET['url'])){
      $url = rtrim($_GET['url'], '/');  // 文字列の最後から"/"を除去する
      $url = filter_var($url, FILTER_SANITIZE_URL); // URL形式にサニタイズする
      $url = explode('/', $url); // "/" で分けて配列に変換する
      return $url;
    }
  }
}