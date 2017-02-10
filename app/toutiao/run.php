<?php
date_default_timezone_set('PRC');

define('ROOT_PATH', __DIR__ . '/../../');

require_once ROOT_PATH . 'libs/Request.php';
require_once ROOT_PATH . 'libs/simple_html_dom.php';
require_once ROOT_PATH . 'libs/Db.php';


define('BASE_URL', 'https://toutiao.io');
define('URL_TPL', BASE_URL . '/prev/%s');

function getContentByDate($date) {
    $html = (new Request)->get(sprintf(URL_TPL, $date));
    $dom = new simple_html_dom();
    $dom->load($html);
    $post = $dom->find('.post');

    if ($post && is_array($post)) {
        foreach ($post as $num => $v) {
            $a    = $v->find('.title a');
            $meta = $v->find('.meta');
            if ($a && is_array($a)) {
                foreach ($a as $k => $v) {
                    $data[$num]['title'] = $v->innertext();
                    $data[$num]['href']  = BASE_URL . $v->getAttribute('href');
                }
            }

            if ($meta && is_array($meta)) {
                foreach ($meta as $k => $v) {
                    $data[$num]['source'] = preg_replace('/\s+(.+)&nbsp.+/', '$1', $v->innertext());
                }
            }
        }
    }

    return $data;
}

function save($date, $data) {
    $time = time();
    $str  = '';
    foreach ($data as $value) {
        $str .= "('{$value['title']}', '{$value['href']}', '{$value['source']}', {$time}, '$date'),";
    }
    $str = rtrim($str, ',');
    $db = Db::getInstance([
        'host'     => '127.0.0.1',
        'user'     => 'root',
        'password' => '',
        'database' => 'develop',
    ]);
    $sql = "insert into toutiao(title, href, source, create_time, blog_date) values $str";
    return $db->query($sql);
}


$date = date('Y-m-d');
$data = getContentByDate($date);
$r = save($date, $data);
var_dump($r);


