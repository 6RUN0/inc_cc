<?php

/**
 * $Id$
 *
 * @category  Settings
 * @package   Inc_CC
 * @author    boris_t <boris@talovikov.ru>
 * @copyright 2014 (c)
 * @license   http://opensource.org/licenses/MIT MIT
 * @see       https://github.com/evekb/evedev-kb/blob/master/common/includes/class.pageassembly.php
 */
class pIncCCForm extends pageAssembly
{

    public $page;
    private $_opt = array();

    /**
     * Constructor methods for this classes.
     */
    function __construct()
    {
        parent::__construct();
        $this->queue('start');
        $this->queue('form');
    }

    /**
     * Preparation of the form.
     *
     * @return none
     */
    function start()
    {
        $this->page = new Page();
        $this->page->setTitle('Include custom code settings');
        $this->page->addHeader('<link rel="stylesheet" type="text/css" href="' . KB_HOST . '/mods/inc_cc/style.css" />');

        if (isset($_POST['clear'])) {
            config::set('inc_cc_settings', null);
        }

        $this->_opt = config::get('inc_cc_settings');

        if (isset($_POST['add'])) {
            if (isset($_POST['add_options']) && !empty($_POST['add_options'])) {
                $this->_opt[$_POST['add_options']['position']][] = $_POST['add_options']['code'];
                config::set('inc_cc_settings', $this->_opt);
            }
        }

        if (isset($_POST['rm']) || isset($_POST['set'])) {
            if (isset($_POST['set_options']) && !empty($_POST['set_options'])) {
                foreach ($_POST['set_options'] as $position => $arr) {
                    foreach ($arr as $key => $val) {
                        if (isset($_POST['set_options'][$position][$key]['check'])) {
                            unset($this->_opt[$position][$key]);
                            if (isset($_POST['set'])) {
                                $this->_opt[$val['position']][] = $val['code'];
                            }
                        }
                    }
                }
            }
            config::set('inc_cc_settings', $this->_opt);
        }
    }

    /**
     * Render of the form.
     *
     * @return string html
     */
    function form()
    {
        global $smarty;
        $smarty->assign('inc_cc_settings', $this->_opt);
        return $smarty->fetch(get_tpl('./mods/inc_cc/inc_cc_form'));
    }

    /**
     * Build context.
     *
     * @return none
     */
    function context()
    {
        parent::__construct();
        $this->queue('menu');
    }

    /**
     * Render of admin menu.
     *
     * @return string html
     */
    function menu()
    {
        include 'common/admin/admin_menu.php';
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
