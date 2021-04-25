<?php
  class Pages extends Controller
  {
    public function __construct(){

    }

    public function index(){
      $data = [
        'title' => 'My Forum',
      ];

      $this->view('pages/index', $data);
    }
  }