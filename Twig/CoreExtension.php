<?php

namespace CelciusTech\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use CelciusTech\CoreBundle\Helper\Formatter;

class CoreExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'is_ajax' => new \Twig_Function_Method($this, 'isAjax'),
            'money' => new \Twig_Function_Method($this, 'money'),
            'percent' => new \Twig_Function_Method($this, 'percent'),
            'more' => new \Twig_Function_Method($this, 'more', array('is_safe' => array('html'))),
            'ago' => new \Twig_Function_Method($this, 'ago'),
        );
    }

    public function isAjax()
    {
        return $this->container->get('request')->isXmlHttpRequest();
    }

    /**
     * Return currency formatted number
     *
     * @param float $number
     * @param string $curreny
     * @param boolean $prefix true if prefix, false if suffix
     * @param string $locale
     *
     * @return string formatted number
     */
    public function money($number, $currency = 'Rp', $prefix = true, $locale = null)
    {
        if (is_null($locale)) {
            $locale = $this->container->get('request')->getLocale();
        }

        return Formatter::money($number, $currency, $prefix, $locale);
    }

    /**
     * Returns a percented value
     *
     * @param string $value
     *
     * @return string
     */
    public function percent($value)
    {
        if ($value <= 0) return '0%';
        return trim(rtrim($value, '0'), '.').'%';
    }

    /**
     * Read more
     *
     * @param string text
     * @param integer length
     *
     * @return string truncated text
     */
    public function more($text, $len = 200)
    {
        return Formatter::more($text, $len);
    }

    /**
     * @link http://css-tricks.com/snippets/php/time-ago-function/
     * Return time in ago format
     *
     * @param Datetime
     *
     * @return string formated
     */
    public function ago(\DateTime $date)
    {
        return Formatter::ago($date);
    }

    public function getName()
    {
        return 'ct_extension';
    }
}

