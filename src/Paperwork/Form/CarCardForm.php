<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:50 PM
 */

namespace App\Paperwork\Form;


use App\Entity\CarCard;
use App\Paperwork\DataField;
use App\Paperwork\Field\Data;
use App\Paperwork\Field\FieldInterface;
use App\Paperwork\Line\LineInterface;

class CarCardForm implements FormInterface
{
    public const HEIGHT = 1;
    public const WIDTH = 2 + 5/8;

    private const BASE_FIELD_HEIGHT = self::HEIGHT / 2;

    /** @var FieldInterface[] */
    private $dataFields = [];

    public function __construct(CarCard $carCard)
    {
        $carInitial = new Data(0, 0, static::WIDTH/2, static::BASE_FIELD_HEIGHT);
        $carNumber = Data::createAtFieldsRight($carInitial, static::WIDTH/2, static::BASE_FIELD_HEIGHT);

        $aar = Data::createAtFieldsBottom($carInitial, static::WIDTH/2, static::BASE_FIELD_HEIGHT/2);
        $length = Data::createAtFieldsBottom($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT/2);
        $description = Data::createAtFieldsRight($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT);

        $this->dataFields = [
            new DataField($carCard->getReportingMark(), $carInitial),
            new DataField($carCard->getCarNumber(), $carNumber),
            new DataField($carCard->getAarType(), $aar),
            new DataField($carCard->getLengthCapacity(), $length),
            new DataField($carCard->getDescription(), $description),
        ];
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->dataFields;
    }

    /**
     * @return LineInterface[]
     */
    public function getLines(): array
    {
        return [];
    }
}