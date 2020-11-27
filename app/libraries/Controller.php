<?php
/* Base controller that loads the models and views */
// naming convention: controllers plural, models singular

// this gets called from individual controllers (Pages.php) and passes the model Class as arg (Post.php)
class Controller {
  //load model
  public function model($model) {
    // require model file
    require_once '../app/models/' . $model . '.php';

    // Instantiate model - cool syntax
    return new $model();
  }

  // load view from /views; then pass in dynamic data with the array
  public function view($view, $data = []) {
    if(file_exists('../app/views/' . $view . '.php')) {
      require_once '../app/views/' . $view . '.php';
    } else {
      // View does not exist; Asta La Vista Motherflower
      die('View does not exist mofo! This is the base controller. Everyone has me and fears my wrath!');
    }
  }

}
