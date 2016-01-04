<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 5:54 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Commands;


class MenuItem
{

    private $href;

    private $label;

    private $selected;

    private $icon;

    /**
     * for subarrays
     * @var MenuItem[]
     */
    private $menuItemArray;

    function __construct($href, $label, $icon = '', $selected = false)
    {
        $this->href = $href;
        $this->label = $label;
        $this->icon = $icon;
        if ($selected) {
            $this->selected = 'active';
        } else {
            $this->selected = '';
        }

    }

    public function hasSubItems()
    {
        return sizeof($this->menuItemArray) > 0;
    }

    /**
     * @param MenuItem []
     */
    public function setMenuItemArray($menuItemArray)
    {
        $this->menuItemArray = $menuItemArray;
    }

    /**
     * @return MenuItem[]
     */
    public function getMenuItemArray()
    {
        return $this->menuItemArray;
    }


    /**
     * @param mixed $icon
     */
    public
    function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public
    function getIcon()
    {
        return $this->icon;
    }


    /**
     * @param mixed $href
     */
    public
    function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public
    function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $label
     */
    public
    function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public
    function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $selected
     */
    public
    function setSelected($selected)
    {
        if ($selected) {
            $this->selected = "active";
        } else {
            $this->selected = "";
        }
    }

    /**
     * @return mixed
     */
    public
    function getSelected()
    {
        return $this->selected;
    }

    function __toString()
    {
        return $this->getLabel();
    }


}