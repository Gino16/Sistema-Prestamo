<?php
class ViewModel {
  protected static function getViewModel($view){
    $whiteList = ["home", 
    "client-list", "client-new", "client-search", "client-update", 
    "company", 
    "item-list", "item-new", "item-search", "item-update",
    "reservation-list", "reservation-new", "reservation-pending", "reservation-reservation", "reservation-search", "reservation-update",
    "user-list", "user-new", "user-search", "user-update"
  ];
    if (in_array($view, $whiteList)) {
      if(is_file("./views/contents/".$view."-view.php")){
        $content = "./views/contents/".$view."-view.php";
        
        
      }else {
        $content = "404";
      }
    } elseif($view == "login" || $view == "index"){
      $content = "login";
    }else {
      $content = "404";
    }
    return $content;
  }
}
