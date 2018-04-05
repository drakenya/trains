<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 4:16 PM
 */

namespace App\Paperwork\Form;


interface FormInterface
{
    public function getFields(): array;
    public function getLines(): array;
}