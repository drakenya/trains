<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/11/18
 * Time: 8:47 AM
 */

namespace App\Paperwork\Creator;


class UnknownFieldType extends \Exception
{
    public function __construct(string $fieldType)
    {
        parent::__construct(sprintf('Unknown field type: %s', $fieldType));
    }
}