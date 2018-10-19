<?php
/**
 * Created by PhpStorm.
 * User: pbrun
 * Date: 01/06/15
 * Time: 17:21.
 */

namespace App\View\Template;

use Pagerfanta\View\Template\Template;

class FoundationTemplate extends Template
{
    /**
     * @var array
     */
    protected static $defaultOptions = [
        'prev_message' => 'Previous',
        'next_message' => 'Next',
        'dots_message' => '&hellip;',
        'active_suffix' => '',
        'css_container_class' => 'pagination',
        'css_prev_class' => 'pagination-previous',
        'css_next_class' => 'pagination-next',
        'css_dots_class' => 'ellipsis',
        'css_active_class' => 'current',
        'css_disabled_class' => 'unavailable',
    ];

    /**
     * @return string
     */
    public function container()
    {
        return sprintf(
            '<ul class="%s" role="navigation" aria-label="Pagination">%%pages%%</ul>',
            $this->option('css_container_class')
        );
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function page($page)
    {
        $text = $page;

        return $this->pageWithText($page, $text);
    }

    /**
     * @param int    $page
     * @param string $text
     *
     * @return string
     */
    public function pageWithText($page, $text)
    {
        $class = null;

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    /**
     * @param int    $page
     * @param string $text
     * @param string $class
     *
     * @return string
     */
    public function pageWithTextAndClass($page, $text, $class)
    {
        $href = $this->generateRoute($page);

        return $this->linkLi($class, $href, $text);
    }

    /**
     * @return string`
     */
    public function previousDisabled()
    {
        $class = $this->previousDisabledClass();
        $text = $this->option('prev_message');

        return $this->linkLi($class, '', $text);
    }

    /**
     * @return string
     */
    public function previousDisabledClass()
    {
        return $this->option('css_prev_class').' '.$this->option('css_disabled_class');
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function previousEnabled($page)
    {
        $text = $this->option('prev_message');
        $class = $this->option('css_prev_class');

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    /**
     * @return string
     */
    public function nextDisabled()
    {
        $class = $this->nextDisabledClass();
        $text = $this->option('next_message');

        return $this->linkLi($class, '', $text);
    }

    /**
     * @return string
     */
    public function nextDisabledClass()
    {
        return $this->option('css_next_class').' '.$this->option('css_disabled_class');
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function nextEnabled($page)
    {
        $text = $this->option('next_message');
        $class = $this->option('css_next_class');

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    /**
     * @return string
     */
    public function first()
    {
        return $this->page(1);
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function last($page)
    {
        return $this->page($page);
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function current($page)
    {
        $text = trim($page.' '.$this->option('active_suffix'));
        $class = $this->option('css_active_class');
        $href = $this->generateRoute($page);

        return $this->linkLi($class, $href, $text);
    }

    /**
     * @return string
     */
    public function separator()
    {
        $class = $this->option('css_dots_class');
        $text = $this->option('dots_message');

        return $this->linkLi($class, '', $text);
    }

    /**
     * @param string $class
     * @param string $href
     * @param string $text
     *
     * @return string
     */
    protected function linkLi($class, $href, $text)
    {
        $liClass = $class ? sprintf(' class="%s"', $class) : '';

        return sprintf('<li%s><a href="%s">%s</a></li>', $liClass, $href, $text);
    }

    /**
     * @param string $class
     * @param string $text
     *
     * @return string
     */
    protected function spanLi($class, $text)
    {
        $liClass = $class ? sprintf(' class="%s"', $class) : '';

        return sprintf('<li%s><span>%s</span></li>', $liClass, $text);
    }
}
