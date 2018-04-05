<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 8:32 PM
 */

namespace App\Paperwork;


use App\Paperwork\Field\FieldInterface;

class DataField
{
    private $field;
    private $data;

    public function __construct(?string $data, FieldInterface $field)
    {
        $this->data = $data;
        $this->field = $field;
    }

    /**
     * @return FieldInterface
     */
    public function getField(): FieldInterface
    {
        return $this->field;
    }

    /**
     * @return null|string
     */
    public function getData(): ?string
    {
        return $this->data;
    }
}