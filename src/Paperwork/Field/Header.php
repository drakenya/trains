<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 2:30 PM
 */

namespace App\Paperwork\Field;


class Header extends BaseField
{
    public function getType(): string
    {
        return FieldTypes::HEADER;
    }
}