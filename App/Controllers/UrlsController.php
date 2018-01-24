<?php

/**
 * Description of UrlsController
 *
 * @author Ricardo Freitas Jr
 */

namespace App\Controllers;

use ricardo\Controller\Action;
use ricardo\Helper\simple_html_dom;

class UrlsController extends Action {

  protected $url;
  private $result;
  private $file;
  private $folder;
  private $baseDir;

  public function index() {
    $this->url = $this->loadModel('Url');
    $query = array('conditions' => array('status' => 'Pendente'));
    $this->url->result = $this->url->select($query);

    if (!empty($this->url->result)) {
      foreach ($this->url->result as $key => $item) {
	var_dump($item);

	$html = new simple_html_dom();
	if ($html->load_file($item['url'])) {
	  /* correcao das urls */
	  $old = array();
	  $new = array();

	  /* css to perfect url */
	  foreach ($html->find("link") as $index => $link) {
	    $old[] = $link->href;
	    $new[] = $this->perfect_url($link->href, $item['url']);
	  }

	  /* js to perfect url */
	  foreach ($html->find("script") as $link) {
	    $old[] = $link->src;
	    $new[] = $this->perfect_url($link->src, $item['url']);
	  }
	  /* outras possíveis validações de url podem ser implementadas futuramente */

	  $html->content = str_replace($old, $new, $html->content);
	  /* valida folder */
	  $url = parse_url($item['url']);
	  $this->baseDir = 'files/';
	  $this->folder = $this->toSecurity($item['id_user']) . '/' . $url['host'];
	  if (!file_exists($this->baseDir . $this->folder) && !is_dir($this->baseDir . $this->folder)) {
	    mkdir($this->baseDir . $this->folder, 0777, true);
	  }
	  $this->file = $this->baseDir . $this->folder . '/index.html';

	  /* cria o arquivo */
	  $myfile = fopen($this->file, "w") or die("Unable to open file!");
	  fwrite($myfile, $html->content);
	  fclose($myfile);
	  $item['path'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/public/files/' . $this->folder;
	}

	$html->response = $this->parseHeaders($html->response);
	$item['status'] = $html->response['type'];
	$item['status_code'] = $html->response['status_code'];
	$item['modified'] = date("Y-m-d H:i:s");
	$this->url->data = $item;

	/*  Atualiza o status da url */
	if ($this->url->update()) {
	  var_dump($this->url->data);
	} else {
	  var_dump('Não foi possível salvar a URL.');
	}
	echo '</div>';
	echo '<hr>';
      }
    } else {
      var_dump('Não existem registros para serem atualizados');
    }
  }

  private function rel2abs($rel, $base) {
    if (parse_url($rel, PHP_URL_SCHEME) != '') {
      return $rel;
    }

    if ($rel[0] == '#' || $rel[0] == '?') {
      return $base . $rel;
    }

    extract(parse_url($base));
    $path = preg_replace('#/[^/]*$#', '', $path);
    if ($rel[0] == '/') {
      $path = '';
    }

    $abs = "$host$path/$rel";
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for ($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {

    }

    $abs = str_replace("../", "", $abs);

    return $scheme . '://' . $abs;
  }

  private function perfect_url($u, $b) {
    $bp = parse_url($b);
    if (!isset($bp['path']))
      $bp['path'] = '';

    if (($bp['path'] != "/" && $bp['path'] != "") || $bp['path'] == '') {
      if ($bp['scheme'] == "") {
        $scheme = "http";
      } else {
        $scheme = $bp['scheme'];
      }
      $b = $scheme . "://" . $bp['host'] . "/";
    }
    if (substr($u, 0, 2) == "//") {
      $u = "http:" . $u;
    }
    if (substr($u, 0, 4) != "http") {
      $u = $this->rel2abs($u, $b);
    }
    return $u;
  }

  private function parseHeaders($headers) {
    $head = array();
    foreach ($headers as $k => $v) {
      $t = explode(':', $v, 2);
      if (!isset($t[1])) {
	if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
	  $head['status_code'] = $v;
	  $head['type'] = intval($out[1]);
	}
      }
    }
    $head['type'] = $this->http_response_code($head['type']);
//    var_dump($response_code);
//    $response_code = $this->http_response_code($head);
//    return $response_code;
    return $head;
  }

  private function http_response_code($code) {
    switch ($code) {
      case 100: $status_code = 'Continue';
	break;
      case 101: $status_code = 'Switching Protocols';
	break;
      case 200: $status_code = 'Concluído';
	break;
      case 201: $status_code = 'Created';
	break;
      case 202: $status_code = 'Accepted';
	break;
      case 203: $status_code = 'Non-Authoritative Information';
	break;
      case 204: $status_code = 'No Content';
	break;
      case 205: $status_code = 'Reset Content';
	break;
      case 206: $status_code = 'Partial Content';
	break;
      case 300: $status_code = 'Multiple Choices';
	break;
      case 301: $status_code = 'Moved Permanently';
	break;
      case 302: $status_code = 'Moved Temporarily';
	break;
      case 303: $status_code = 'See Other';
	break;
      case 304: $status_code = 'Not Modified';
	break;
      case 305: $status_code = 'Use Proxy';
	break;
      case 400: $status_code = 'Erro';
	break;
      case 401: $status_code = 'Erro';
	break;
      case 402: $status_code = 'Payment Required';
	break;
      case 403: $status_code = 'Forbidden';
	break;
      case 404: $status_code = 'Erro';
	break;
      case 405: $status_code = 'Method Not Allowed';
	break;
      case 406: $status_code = 'Not Acceptable';
	break;
      case 407: $status_code = 'Proxy Authentication Required';
	break;
      case 408: $status_code = 'Request Time-out';
	break;
      case 409: $status_code = 'Conflict';
	break;
      case 410: $status_code = 'Gone';
	break;
      case 411: $status_code = 'Length Required';
	break;
      case 412: $status_code = 'Precondition Failed';
	break;
      case 413: $status_code = 'Request Entity Too Large';
	break;
      case 414: $status_code = 'Request-URI Too Large';
	break;
      case 415: $status_code = 'Unsupported Media Type';
	break;
      case 500: $status_code = 'Internal Server Error';
	break;
      case 501: $status_code = 'Not Implemented';
	break;
      case 502: $status_code = 'Bad Gateway';
	break;
      case 503: $status_code = 'Service Unavailable';
	break;
      case 504: $status_code = 'Gateway Time-out';
	break;
      case 505: $status_code = 'HTTP Version not supported';
	break;
      default:
//	$status_code = 'Status Code Desconhecido: "' . htmlentities($code) . '"';
	$status_code = 'Pendente';
	break;
    }

    return $status_code;
  }

}
