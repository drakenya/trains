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
    private const BASE_FIELD_HEIGHT = 0.5;
    private const BASE_FIELD_HEIGHT_SLICES = 5;

    /** @var FieldInterface[] */
    private $headerFields = [];
    /** @var FieldInterface[] */
    private $dataFields = [];
    /** @var LineInterface[] */
    private $lines = [];
    
    public function __construct(Waybill $waybill)
    {
        $formHeader = new FormType(0, 0, static::WIDTH, static::BASE_FIELD_HEIGHT);

        $carInitial = new Header($formHeader->getLeft(), $formHeader->getBottom(), static::WIDTH/2, static::BASE_FIELD_HEIGHT);
        $carNumber = Header::createAtFieldsRight($carInitial, static::WIDTH/2, static::BASE_FIELD_HEIGHT);

        $aar = Header::createAtFieldsBottom($carInitial, static::WIDTH/2, static::BASE_FIELD_HEIGHT/2);
        $len = Header::createAtFieldsBottom($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT/2);
        $desc = Header::createAtFieldsRight($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT);

        $to = Header::createAtFieldsBottom($len, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $toData = Data::createAtFieldsBottom($to, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);
        $from = Header::createAtFieldsRight($to, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $fromData = Data::createAtFieldsBottom($from, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);

        $consignee = Header::createAtFieldsBottom($toData, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $consigneeData = Data::createAtFieldsBottom($consignee, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);
        $shipper = Header::createAtFieldsRight($consignee, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $shipperData = Data::createAtFieldsBottom($shipper, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);


        $routeVia = Header::createAtFieldsBottom($consigneeData, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $routeViaData = Data::createAtFieldsBottom($routeVia, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);
        $aarClass = Header::createAtFieldsBottom($shipperData, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/2);
        $aarClassData = Data::createAtFieldsRight($aarClass, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/2);
        $lenCapy = Header::createAtFieldsBottom($aarClass, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/2);
        $lenCapyData = Data::createAtFieldsRight($lenCapy, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/2);

        $spotting = Header::createAtFieldsBottom($routeViaData, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(2/6));
        $spottingData = Data::createAtFieldsRight($spotting, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(2/6));

        $pkgs = Header::createAtFieldsBottom($spotting, static::WIDTH/4, static::BASE_FIELD_HEIGHT*(1/6));
        $pkgsData = Data::createAtFieldsBottom($pkgs, static::WIDTH/4, static::BASE_FIELD_HEIGHT*(3/6));
        $description = Header::createAtFieldsRight($pkgs, static::WIDTH*3/4, static::BASE_FIELD_HEIGHT*(1/6));
        $descriptionData = Data::createAtFieldsRight($pkgsData, static::WIDTH*3/4, static::BASE_FIELD_HEIGHT*(3/6));

        $this->headerFields = [
            new DataField('FREIGHT WAYBILL', $formHeader),
            new DataField('CAR INITIAL', $carInitial),
            new DataField('CAR NUMBER', $carNumber),
            new DataField('AAR', $aar),
            new DataField('LEN/CAPY', $len),
            new DataField('DESC', $desc),
            new DataField('FROM   STATION   STATE', $from),
            new DataField('TO     STATION   STATE', $to),
            new DataField('SHIPPER', $shipper),
            new DataField('CONSIGNEE & ADDRESS', $consignee),
            new DataField('AAR CLASS', $aarClass),
            new DataField('LEN/CAPY', $lenCapy),
            new DataField('ROUTE/VIA', $routeVia),
            new DataField('SPOTTING INSTRUCTIONS', $spotting),
            new DataField('# PKGS', $pkgs),
            new DataField('DESCRIPTION OF ARTICLES', $description),
        ];

        $this->dataFields = [
            new DataField($waybill->getFromAddress(), $fromData),
            new DataField($waybill->getToAddress(), $toData),
            new DataField($waybill->getShipper(), $shipperData),
            new DataField($waybill->getConsignee(), $consigneeData),
            new DataField($waybill->getAarClass(), $aarClassData),
            new DataField($waybill->getLengthCapacity(), $lenCapyData),
            new DataField($waybill->getRouteVia(), $routeViaData),
            new DataField($waybill->getSpotLocation(), $spottingData),
            new DataField($waybill->getLadingQuantity(), $pkgsData),
            new DataField($waybill->getLadingDescription(), $descriptionData),
        ];

        $verticalLines = [
            VerticalLine::createAtFieldRight($carInitial),
            VerticalLine::createAtFieldRight($aar),
            VerticalLine::createAtFieldRight($len),
            VerticalLine::createAtFieldRight($to),
            VerticalLine::createAtFieldRight($toData),
            VerticalLine::createAtFieldRight($consignee),
            VerticalLine::createAtFieldRight($consigneeData),
            VerticalLine::createAtFieldRight($routeVia),
            VerticalLine::createAtFieldRight($routeViaData),
        ];
        $horizontalLines = [
            HorizontalLine::createAtFieldBottom($carInitial),
            HorizontalLine::createAtFieldBottom($carNumber),
            HorizontalLine::createAtFieldBottom($len),
            HorizontalLine::createAtFieldBottom($desc),
            HorizontalLine::createAtFieldBottom($fromData),
            HorizontalLine::createAtFieldBottom($toData),
            HorizontalLine::createAtFieldBottom($shipperData),
            HorizontalLine::createAtFieldBottom($consigneeData),
            HorizontalLine::createAtFieldBottom($aarClass),
            HorizontalLine::createAtFieldBottom($aarClassData),
            HorizontalLine::createAtFieldBottom($lenCapy),
            HorizontalLine::createAtFieldBottom($lenCapyData),
            HorizontalLine::createAtFieldBottom($routeViaData),
            HorizontalLine::createAtFieldBottom($spotting),
            HorizontalLine::createAtFieldBottom($spottingData),
        ];
        $this->lines = array_merge($verticalLines, $horizontalLines);
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return array_merge($this->headerFields, $this->dataFields);
    }

    /**
     * @return LineInterface[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}