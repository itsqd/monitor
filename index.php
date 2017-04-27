<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'src/Database.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$d = new Database();
$d->select("select * from itsqd_mon_messages where (flg_stat = 0 or flg_stat is null)");