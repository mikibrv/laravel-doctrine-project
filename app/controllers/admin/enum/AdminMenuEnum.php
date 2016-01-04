<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 5:58 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;


use Transp\Commands\MenuItem;

abstract class AdminMenuEnum
{

    public static function LEFT_MENU($selected = null)
    {
        $menu = array();
        $menu['home'] = AdminMenuEnum::HOME();
        $menu['pages'] = AdminMenuEnum::PAGES();
        $menu['content'] = AdminMenuEnum::CONTENT();
        $menu['stats'] = AdminMenuEnum::STATS();


        /**
         * the one selected
         */
        if ($selected != null && array_key_exists($selected, $menu)) {
            $menu[$selected]->setSelected(true);
        }

        return $menu;
    }


    public static function HOME($selected = false)
    {
        return new MenuItem("/admin", "Curse", "fa-cab", $selected);
    }

    public static function PAGES($selected = false)
    {
        return new MenuItem("/admin/site/pagini-web", "Administrare pagini", "fa-windows", $selected);
    }

    public static function CONTENT($selected = false)
    {
        return new MenuItem("/admin/site/continut", "Administrare conținut", "fa-book", $selected);
    }

    public static function STATS($selected = false)
    {
        return new MenuItem("/admin/statistici", "Vizualizare statistici", "fa-pie-chart", $selected);
    }


} 