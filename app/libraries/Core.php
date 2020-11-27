<?php
/* App Core class
creates URL and loads core controller
URL format will be /controller/method/params
*/
class Core {
  protected $currentController = 'Pages'; // direct here first
  protected $currentMethod = 'index'; // then get index
  protected $params = [];  // and ingest parameters

  public function __construct() {
    // print_r($this->getUrl());   // print an array
    $url = $this->getUrl();

    // Look in controllers for first value of array; must still ../ out of current dir since we are still in /public/index
    // ucwords() makes Pascal case
    if(file_exists('../app/controllers/' . ucwords($url[0]).'.php')) { // looking for Posts.php
      // if the file exists set it as the controller and overwrite 'Pages' which is the default
      $this->currentController = ucwords($url[0]);
      // unset 0 index
      unset($url[0]);
    }
    // require in the controller
    require_once '../app/controllers/' . $this->currentController . '.php';
    // instantiate the controller
    $this->currentController = new $this->currentController;
    // check for 2nd part of URL
    if(isset($url[1])) {
      // check for method in controller
      if(method_exists($this->currentController, $url[1])) {
        // set that currrent method from url[1]
        $this->currentMethod = $url[1];
        // unset [1] index; do not forget to unset every index after being used!!
        unset($url[1]);
      }
    }
    // get params with ternary operation
    $this->params = $url ? array_values($url) : [];
    // calling both controller and method and passing in params; - geez louise
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }


  // the current controller and method will change with URL
  // create method to fetch URL and put into $params []
  // done with $_GET
  public function getUrl() {
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');  // trim off the forward slash
      $url = filter_var($url, FILTER_SANITIZE_URL);  // SANITIZE $url
      // create array for example: [post, edit, 1] with explode()
      $url = explode('/', $url);
      return $url;
    }
  }
}
