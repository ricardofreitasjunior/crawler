<?php

/**
 * Description of Conn
 *
 * @author Ricardo Freitas Jr
 */

namespace ricardo\Controller;

use App\Config\Database;

class Conn extends Database {

  private static $Database;

  /** @var PDO */
  private static $Connect = null;

  private static function Conectar() {
    
//    if ($_SERVER["SERVER_NAME"] == '127.0.0.1') { // homologacao
//      self::$Database = self::$homologacao;
//    } else { // localhost
      self::$Database = self::$localhost;
//    }
    try {
      if (self::$Connect == null) {
	$dsn = 'mysql:host=' . self::$Database['host'] . ';dbname=' . self::$Database['database'];
                $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
	self::$Connect = new \PDO($dsn, self::$Database['login'], self::$Database['password'], $options);
      }
    } catch (PDOException $e) {
      var_dump($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
      die;
    }

    self::$Connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return self::$Connect;
  }

  /** Retorna um objeto PDO Singleton Pattern. */
  public static function getConn() {
    return self::Conectar();
  }

}
