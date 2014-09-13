<?php


$modInfo['inc_cc']['name'] = 'Include custom code';
$modInfo['inc_cc']['abstract'] = 'Include custom code in every page (e.g. <a href="http://www.google.com/analytics/">google analytics</a>, <a href="http://metrika.yandex.ru/">yandex metrics</a>)';
$modInfo['inc_cc']['about'] = 'by <a href="https://github.com/6RUN0">boris_t</a><br /><a href="https://github.com/6RUN0/inc_cc">Get ' . $modInfo['inc_cc']['name'] . '</a>';

class incCC {

  public static $opt = array();

  function init() {
    self::$opt = config::get('inc_cc_settings');
  }

  public static function add_head(&$page) {
    if(isset(self::$opt['head']) && !empty(self::$opt['head'])) {
      foreach(self::$opt['head'] as $head) {
        $page->addHeader($head);
      }
    }
  }

  public static function add_body(&$page) {
    if(isset(self::$opt['body']) && !empty(self::$opt['body'])) {
      foreach(self::$opt['body'] as $body) {
        $page->addBody($body);
      }
    }
  }

}

incCC::init();
event::register('page_assembleheader', 'incCC::add_head');
event::register('page_assemblebody', 'incCC::add_body');
