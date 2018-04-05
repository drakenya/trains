<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 4:01 PM
 */

namespace App\Paperwork\Line;


interface LineInterface
{
    public function getTop(): float;
    public function getLeft(): float;
    public function getHeight(): float;
    public function getWidth(): float;
    public function getType(): string;
}