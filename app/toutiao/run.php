<?php
date_default_timezone_set('PRC');

define('ROOT_PATH', __DIR__ . '/../../');

require_once ROOT_PATH . 'libs/Request.php';
require_once ROOT_PATH . 'libs/simple_html_dom.php';


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
                    $data[$num][$k]['title'] = $v->innertext();
                    $data[$num][$k]['href']  = BASE_URL . $v->getAttribute('href');
                }
            }

            if ($meta && is_array($meta)) {
                foreach ($meta as $k => $v) {
                    $data[$num][$k]['source'] = preg_replace('/\s+(.+)&nbsp.+/', '$1', $v->innertext());
                }
            }
        }
    }

    return $data;
}

print_r(getContentByDate(date('Y-m-d')));

