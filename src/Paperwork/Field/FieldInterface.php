<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:58 PM
 */

namespace App\Paperwork\Field;


interface FieldInterface
{
    public function getTop(): float;
    public function getBottom(): float;
    public function getLeft(): float;
    public function getRight(): float;
    public function getHeight(): float;
    public function getWidth(): float;
    public function getType(): string;
}