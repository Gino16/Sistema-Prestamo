<?php
require_once "./models/viewModel.php";
class ViewController extends ViewModel{
  
  public function getTemplateController()
  {
    return require_once "./views/template.php"; 
  }

  public function getViewController()
  {
    if (isset($_GET["view"])) {
      // $route[] =[ 0 -> view, 1 -> method, 2 -> parameters]
      $route = explode("/", $_GET["view"]);
      $response = ViewModel::getViewModel($route[0]);
    }else {
      $response = "login";
    }
    return $response;
  }
}
