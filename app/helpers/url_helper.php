<?php

// リダイレクトを行うヘルパー関数
// 使い方の例 - redirect('users/login')

  function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
  }