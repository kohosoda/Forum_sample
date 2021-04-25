<?php
  // Configファイルを読み込む
  require_once 'config/config.php';

  // プログラム内で未定義のクラスをインスタンス化した場合、
  // Librariesディレクトリ内のクラスを自動で読み込む
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });

  // ヘルパー関数を読み込む
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';