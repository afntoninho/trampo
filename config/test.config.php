<?php
return array(
  'db' => array(
    'driver' => 'PDO',
    'dsn'    => 'mysql:dbname=siscodi_test;host=localhost',
    'username' => 'root',
    'password' => '',
    'driver_options' => array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    ),
));