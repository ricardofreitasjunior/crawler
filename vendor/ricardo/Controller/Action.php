<?php

/**
 * Description of Action
 *
 * @author Ricardo Freitas Jr
 */

namespace ricardo\Controller;

use ricardo\Controller\Conn;
use ricardo\Helper\Html;
use ricardo\Helper\Message;

abstract class Action {

  protected $layout = 'default';
  protected $view;
//  protected $html;
//  protected $message;
  private $controller;
  private $action;

  public function __construct() {
    $this->view = new \stdClass();
//    $this->message = new Message();
  }

  protected function getController() {
    $current = get_class($this);
    $singleClassName = strtolower((str_replace("Controller", "", str_replace("App\\Controllers\\", "", $current))));
    $this->controller = $singleClassName;
  }

  protected function render($action, $layout = true) {
//    $this->html = new Html();

    $this->getController();
    $this->action = $action;
    if ($layout == true && file_exists("../App/Views/layouts/{$this->layout}.phtml")) {
      include_once "../App/Views/layouts/{$this->layout}.phtml";
    } else {
      $this->content();
    }
  }

  protected function content() {
    $this->getController();
    include_once "../App/Views/" . $this->controller . "/" . $this->action . ".phtml";
  }

  public static function loadModel($model) {
    $class = "App\\Models\\" . ucfirst($model);
    return new $class(Conn::getConn());
  }

  public function toSecurity($value) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', 'widesoft');
    $iv = substr(hash('sha256', 'widesoft'), 0, 16);
    $output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
  }

  public function fromSecurity($value) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', 'widesoft');
    $iv = substr(hash('sha256', 'widesoft'), 0, 16);
    $output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);

    return $output;
  }

}
