<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:50 PM
 */

namespace App\Paperwork\Form;


use App\Entity\Waybill;
use App\Paperwork\DataField;
use App\Paperwork\Field\Data;
use App\Paperwork\Field\FieldInterface;
use App\Paperwork\Field\FormType;
use App\Paperwork\Field\Header;
use App\Paperwork\Line\HorizontalLine;
use App\Paperwork\Line\LineInterface;
use App\Paperwork\Line\VerticalLine;

class WaybillForm extends BaseForm
{
    public const BASE_FIELD_HEIGHT = 0.5;

    /** @var FieldInterface[] */
    private $fields = [];
    /** @var LineInterface[] */
    private $lines = [];
    
    public function __construct(array $fields, array $lines, Waybill $waybill)
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