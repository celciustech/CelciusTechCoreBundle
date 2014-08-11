<?php

namespace CelciusTech\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CommaToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transform array to comma separated text
     *
     * @param array $arr
     *
     * @return string $text (separated by comma)
     */
    public function transform($arr = array())
    {
        return implode(',', $arr);
    }

    /**
     * Transform comma separated text to array
     *
     * @param string $text
     *
     * @return array $arr
     */
    public function reverseTransform($text)
    {
        return explode(',', $text);
    }
}
