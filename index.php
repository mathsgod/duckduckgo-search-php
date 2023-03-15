<?php


require_once 'vendor/autoload.php';



$s = new DuckDuckGo;


print_r($s->search('price of iphone14', "hk-tzh"));
