<?php

/**
 * Description of Database_config
 *
 * @author Ricardo Freitas Jr
 */

namespace app\Config;

class Database {

    protected static $producao = array(
//        'datasource' => 'Database/Mysql',
//        'persistent' => true,
        'host' => '',
        'login' => '',
        'password' => '',
        'database' => '',
//        'prefix' => '',
            //'encoding' => 'utf8',
    );
    protected static $homologacao = array(
//        'datasource' => 'Database/Mysql',
//        'persistent' => false,
        'host' => '',
        'login' => '',
        'password' => '',
        'database' => '',
//        'prefix' => '',
            //'encoding' => 'utf8',
    );
    protected static $localhost = array(
//        'datasource' => 'Database/Mysql',
//        'persistent' => false,
        'host' => '127.0.0.1',
        'login' => 'root',
        'password' => 'kayz123',
        'database' => 'widesoft',
//        'prefix' => '',
            //'encoding' => 'utf8',
    );

}
