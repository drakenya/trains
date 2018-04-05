<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 2:31 PM
 */

namespace App\Paperwork\Field;


class Data extends BaseField
{
    public function getType(): string
    {
        return FieldTypes::DATA;
    }
}