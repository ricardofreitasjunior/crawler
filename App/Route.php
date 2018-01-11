<?php

/**
 * Description of Route
 *
 * @author Ricardo Freitas Jr
 */

namespace App;

use ricardo\Init\Bootstrap;

class Route extends Bootstrap {

  protected function initRoutes() {
    $routes['url'] = array('route' => '/', 'controller' => 'UrlsController', 'action' => 'index');
    $this->setRoutes($routes);
  }

}
