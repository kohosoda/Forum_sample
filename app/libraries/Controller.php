<?php
/*
 * Controllerクラス
 * 1. modelメソッド：app/models/モデル名.php を読み込んでインスタンス化する
 * 2. viewメソッド ：app/views/ビュー名.php を読み込んで表示する
 */
class Controller {
  public function model($model){
    // 対象の model をインスタンス化して返す
    require_once '../app/models/' . $model . '.php';
    return new $model;
  }

  public function view($view, $data = []){
    if(file_exists('../app/views/' . $view . '.php')){
      // 対象の view が存在する場合、読み込む
      require_once '../app/views/' . $view . '.php';
    } else {
      // 対象の view が存在しない場合、エラー画面を表示させる
      die('View does not exist');
    }
  }

}