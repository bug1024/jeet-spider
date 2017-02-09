<?php

/**
 * A html dom query tool based on simple_html_dom
 *
 * @author Jeet
 * @date 2017-02-09
 */
class HtmlDom {

    private $__html_dom = null;

    public function __construct($html) {
        $this->__html_dom = new simple_html_dom();
        $this->__html_dom->load($html);
    }

    public function find($str) {
        return $this->__html_dom->find($stra);
    }

}

