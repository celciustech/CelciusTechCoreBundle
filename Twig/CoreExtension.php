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
     *
     * @return string formatted number
     */
    public function money($number, $currency = 'Rp', $prefix = true)
    {
        return Formatter::money($number, $currency, $prefix);
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

    public function getName()
    {
        return 'ct_extension';
    }
}

