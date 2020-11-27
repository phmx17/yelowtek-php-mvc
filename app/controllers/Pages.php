<?php
// the 'Pages' controller which is the default
// naming convention: controllers are plural, models are singular !

  // instantiate the Post model in the constructor
  class Pages extends Controller {
    public function __construct() {
      
    }


    // calling views:
    // index is the default method / controller
    // no .php extension since it is added from base controller
    public function index() {
      

      $data = [
        'title' => 'Welcome to Yelow Tek PHP', // associative array
       
      ];
      // call method from Post model

      $this->view('pages/index', $data); 
    }

    // controller for the 'About' view
    public function about() {
      $data = [
        'title' => 'Welcome to the About page.' // associative array
      ];
      $this->view('pages/about', $data);
    }
  }