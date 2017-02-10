<?php

require_once __DIR__ . '/libs/Request.php';
require_once __DIR__ . '/libs/simple_html_dom.php';

$html = (new Request)->get('http://www.baidu.com');
$dom = new simple_html_dom();
$dom->load($html);
$find = $dom->find('title');
$r = $find[0]->innertext();
var_dump($r);
