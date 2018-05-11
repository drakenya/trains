<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/11/18
 * Time: 8:48 AM
 */

namespace App\Paperwork\Creator;


class UnknownDataKeyException extends \Exception
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf('Cannot find location: %s', $key));
    }
}