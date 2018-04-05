<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 10:23 AM
 */

namespace App\Paperwork\Line;


use App\Paperwork\Field\FieldInterface;

class VerticalLine extends BaseLine
{
    public static function createAtFieldRight(FieldInterface $field)
    {
        return new static($field->getRight(), $field->getTop(), $field->getHeight());
    }

    public function __construct(float $left, float $top, float $height)
    {
        parent::__construct($left, $top, 0, $height);
    }

    public function getType(): string
    {
        return LineTypes::VERTICAL;
    }
}