<?php

require_once __DIR__ . '/libs/Request.php';
require_once __DIR__ . '/libs/HtmlDom.php';

$html = (new Request)->get('http://www.baidu.com');
$r = (new HtmlDom($html))->find('.s_tab');
var_dump($r);
