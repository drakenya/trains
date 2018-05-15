<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:50 PM
 */

namespace App\Paperwork\Form;


use App\Paperwork\Field\FieldInterface;
use App\Paperwork\Line\LineInterface;

class WaybillForm
{
    public const BASE_FIELD_HEIGHT = 0.5;

    /** @var FieldInterface[] */
    private $fields = [];
    /** @var LineInterface[] */
    private $lines = [];
    
    public function __construct(array $fields, array $lines)
    {
        $this->fields = $fields;
        $this->lines = $lines;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return LineInterface[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}