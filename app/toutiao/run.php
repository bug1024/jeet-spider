<?php
date_default_timezone_set('PRC');

define('ROOT_PATH', __DIR__ . '/../../');

require_once ROOT_PATH . 'libs/Request.php';
require_once ROOT_PATH . 'libs/simple_html_dom.php';
require_once ROOT_PATH . 'libs/Db.php';

define('BASE_URL', 'https://toutiao.io');
define('URL_TPL', BASE_URL . '/prev/%s');

class Run {

    protected $_db;

    public function __construct() {
        $this->_db = Db::getInstance([
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => '',
            'database' => 'develop',
        ]);
    }

    /**
     * get last n days data
     */
    public function begin($days = 1) {
        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime("-{$i} day"));
            $data = $this->getDataByDate($date);
            if (!$this->dateExist($date)) {
                $res = $this->save($date, $data);
                if ($res === false) {
                    echo $date, " failed\n";
                } else {
                    echo $date, " success\n";
                }
            }
        }
    }

    /**
     * get data by date
     */
    public function getDataByDate($date) {
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

    /**
     * date exsits in db, if exsits then ignore
     */
    public function dateExist($date) {
        $sql = "select count(1) num from toutiao where blog_date = '$date'";
        $res = $this->_db->query($sql);

        while ($myrow = $res->fetch_array(MYSQLI_ASSOC)) {
          $num[] = $myrow["num"];
        }

        return isset($num[0]) && $num[0] > 0;
    }

    /**
     * insert into db
     */
    public function save($date, $data) {
        if (empty($data)) {
            return false;
        }

        $time = time();
        $str  = '';
        foreach ($data as $value) {
            $str .= "('{$value['title']}', '{$value['href']}', '{$value['source']}', {$time}, '$date'),";
        }
        $str = rtrim($str, ',');
        $sql = "insert into toutiao(title, href, source, create_time, blog_date) values $str";

        return $this->_db->query($sql);
    }

}

(new Run)->begin(2000);
