<?php

/**
 * Description of Table
 *
 * @author Ricardo Freitas Jr
 */

namespace ricardo\Model;

abstract class Table {

  protected $db;
  protected $table;
  public $data;

  public function __construct(\PDO $db) {
    $this->db = $db;
  }

  public function fetchAll() {
    try {
      $query = "SELECT * FROM {$this->table} ORDER BY modified DESC";
      $result = $this->db->prepare($query);
      $result->setFetchMode(\PDO::FETCH_ASSOC);
      $result->execute();
      $result = $result->fetchAll();
      return $result;
    } catch (PDOException $e) {
      var_dump(array("<b>Erro ao buscar:</b> {$e->getMessage()}. CODE:{$e->getCode()}"));
    }
  }

  public function findById($id) {
    try {
      $query = "SELECT * FROM {$this->table} WHERE id=:id";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      var_dump(array("<b>Erro ao buscar:</b> {$e->getMessage()}. CODE:{$e->getCode()}"));
    }
  }

  public function select($query = array()) {
    $sql = $this->prepareSQL($query);
    try {
      $result = $this->db->prepare($sql);
      $result->setFetchMode(\PDO::FETCH_ASSOC);
      $result->execute();
      $result = $result->fetchAll();
      return $result;
    } catch (PDOException $e) {
      var_dump(array("<b>Erro ao buscar:</b> {$e->getMessage()}. CODE:{$e->getCode()}"));
    }
  }

  public function update() {
    try {
      foreach ($this->data as $key => $value):
	$places[] = $key . ' = :' . $key;
      endforeach;
      $places = implode(', ', $places);

      $query = "UPDATE {$this->table} SET {$places} WHERE id={$this->data['ID']}";
      $query = $this->db->prepare($query);
      $query->execute($this->data);

      return true;
    } catch (PDOException $e) {
      var_dump(array("<b>Erro ao buscar:</b> {$e->getMessage()}. CODE:{$e->getCode()}"));
      return false;
    }
  }

  private function prepareSql($query) {
    $query = array_merge(array(
	'conditions' => null,
	'fields' => '*',
	'joins' => array(),
	'limit' => null,
	'offset' => null,
	'order' => array('created' => 'DESC'),
	'page' => 1,
	'group' => null,
	'callbacks' => true,
	    ), (array) $query);
    $sql = 'SELECT ';
    if ($query['fields'] != '*') {
      $sql .= implode(', ', $query['fields']);
    } else {
      $sql .= $query['fields'];
    }
    $sql .= ' FROM ' . $this->table;
    if (!empty($query['conditions'])) {
      $sql .= ' WHERE ';
      $count = count($query['conditions']);
      $paramKeys = '';
      $paramVal = '';
      foreach ($query['conditions'] as $key => $value) {
	if (strpos($key, ' IN') || strpos($key, ' LIKE')) {
	  if (is_array($value)) {
	    $value = implode(', ', $value);
	  }
	  $sql .= $key . ' (' . $value . ')';
	} else {
	  $sql .= $key . ' = "' . $value . '"';
	}

	$count--;
	if ($count > 0) {
	  $sql .= ' AND ';
	}
      }
    }
    foreach ($query['order'] as $key => $value) {
      $order[] = $key . ' ' . $value;
    }
    $sql .= ' ORDER BY ' . implode(', ', $order);
    if (!empty($query['limit'])) {
      $sql .= ' LIMIT ' . $query['limit'];
    }
//    var_dump($sql);
    return $sql;
  }

}
