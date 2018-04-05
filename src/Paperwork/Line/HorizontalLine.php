<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 10:23 AM
 */

namespace App\Paperwork\Line;


use App\Paperwork\Field\FieldInterface;

class HorizontalLine extends BaseLine
{
    public static function createAtFieldBottom(FieldInterface $field)
    {
        return new static($field->getLeft(), $field->getBottom(), $field->getWidth());
    }

    public function __construct(float $left, float $top, float $width)
    {
        parent::__construct($left, $top, $width, 0);
    }

    public function getType(): string
    {
        return LineTypes::HORIZONTAL;
    }
}