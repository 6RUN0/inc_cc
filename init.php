<?php

/**
 * $Id$
 *
 * @category  Init
 * @package   Inc_CC
 * @author    boris_t <boris@talovikov.ru>
 * @copyright 2014 (c)
 * @license   http://opensource.org/licenses/MIT MIT
 */

$modInfo['inc_cc']['name'] = 'Include custom code';
$modInfo['inc_cc']['abstract'] = 'Include custom code in every page (e.g. <a href="http://www.google.com/analytics/">google analytics</a>, <a href="http://metrika.yandex.ru/">yandex metrics</a>)';
$modInfo['inc_cc']['about'] = 'by <a href="https://github.com/6RUN0">boris_t</a><br /><a href="https://github.com/6RUN0/inc_cc">Get ' . $modInfo['inc_cc']['name'] . '</a>';

/**
 * Provides callbacks for event::register.
 */
class IncCC
{
    public static $opt = array();

    /**
     * Loading options.
     *
     * @return none
     */
    function init()
    {
        self::$opt = config::get('inc_cc_settings');
    }

    /**
     * Adds code in <header>.
     *
     * @param Page &$page object of class Page
     *
     * @return none
     * @see https://github.com/evekb/evedev-kb/blob/master/common/includes/class.page.php
     */
    public static function add_head(&$page)
    {
        if (isset(self::$opt['head']) && !empty(self::$opt['head'])) {
            foreach (self::$opt['head'] as $head) {
                $page->addHeader($head);
            }
        }
    }

    /**
     * Adds code in <body>.
     *
     * @param Page &$page object of class Page
     *
     * @return none
     * @see https://github.com/evekb/evedev-kb/blob/master/common/includes/class.page.php
     */
    public static function add_body(&$page)
    {
        if (isset(self::$opt['body']) && !empty(self::$opt['body'])) {
            foreach (self::$opt['body'] as $body) {
                $page->addBody($body);
            }
        }
    }

}

IncCC::init();
event::register('page_assembleheader', 'IncCC::add_head');
event::register('page_assemblebody', 'IncCC::add_body');
