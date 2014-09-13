<?php

class pIncCCForm extends pageAssembly {

  public $page;
  private $settings = array();

  function __construct() {
    parent::__construct();
    $this->queue('start');
    $this->queue('form');
  }

  function start() {

    $this->page = new Page();
    $this->page->setTitle('Include custom code settings');
    $this->page->addHeader('<link rel="stylesheet" type="text/css" href="' . KB_HOST . '/mods/inc_cc/style.css" />');

    if(isset($_POST['clear'])) {
      config::set('inc_cc_settings', NULL);
    }

    $this->settings = config::get('inc_cc_settings');

    if(isset($_POST['add'])) {
      if(isset($_POST['add_options']) && !empty($_POST['add_options'])) {
        $this->settings[$_POST['add_options']['position']][] = $_POST['add_options']['code'];
        config::set('inc_cc_settings', $this->settings);
      }
    }

    if(isset($_POST['rm']) || isset($_POST['set'])) {
      if(isset($_POST['set_options']) && !empty($_POST['set_options'])) {
        foreach($_POST['set_options'] as $position => $arr) {
          foreach($arr as $key => $val) {
            if(isset($_POST['set_options'][$position][$key]['check'])) {
              unset($this->settings[$position][$key]);
              if(isset($_POST['set'])) {
                $this->settings[$val['position']][] = $val['code'];
              }
            }
          }
        }
      }
      config::set('inc_cc_settings', $this->settings);
    }

  }

  function form() {
    global $smarty;
    $smarty->assign('inc_cc_settings', $this->settings);
    return $smarty->fetch(get_tpl('./mods/inc_cc/inc_cc_form'));
  }

  function context() {
    parent::__construct();
    $this->queue('menu');
  }

  function menu() {
    require_once('common/admin/admin_menu.php');
    return $menubox->generate();
  }

}

$pageAssembly = new pIncCCForm();
event::call('pIncCCForm_assembling', $pageAssembly);
$html = $pageAssembly->assemble();
$pageAssembly->page->setContent($html);

$pageAssembly->context();
event::call('pIncCCForm_context_assembling', $pageAssembly);
$context = $pageAssembly->assemble();
$pageAssembly->page->addContext($context);

$pageAssembly->page->generate();
