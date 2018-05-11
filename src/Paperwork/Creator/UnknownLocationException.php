<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/11/18
 * Time: 8:47 AM
 */

namespace App\Paperwork\Creator;


class UnknownLocationException extends \Exception
{
    public function __construct(string $location)
    {
        parent::__construct(sprintf('Cannot find location: %s', $location));
    }
}