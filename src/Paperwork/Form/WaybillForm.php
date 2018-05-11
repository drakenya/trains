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

//        $carInitial = new Header($formHeader->getLeft(), $formHeader->getBottom(), static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $carInitial = Header::createAtFieldsBottom($formHeader, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $carInitialData = Data::createAtFieldsRight($carInitial, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $carNumber = Header::createAtFieldsRight($carInitialData, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $carNumberData = Data::createAtFieldsRight($carNumber, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);

        $aar = Header::createAtFieldsBottom($carInitial, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $aarData = Data::createAtFieldsRight($aar, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $len = Header::createAtFieldsRight($aarData, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $lenData = Data::createAtFieldsRight($len, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
//        $desc = Header::createAtFieldsRight($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT);

        $marginLeft = Data::createAtFieldsBottom($aar, static::WIDTH/2, static::BASE_FIELD_HEIGHT/6);
        $marginRight = Data::createAtFieldsRight($marginLeft, static::WIDTH/2, static::BASE_FIELD_HEIGHT/6);

        $stopThisCarAt = Header::createAtFieldsBottom($marginLeft, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/3);
        $stopThisCarAtData = Data::createAtFieldsRight($stopThisCarAt, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/3);
        $stopThisCarAt2 = Header::createAtFieldsBottom($stopThisCarAt, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/3);
        $stopThisCarAt2Data = Data::createAtFieldsRight($stopThisCarAt2, static::WIDTH/2/2, static::BASE_FIELD_HEIGHT/3);

        $waybillDate = Header::createAtFieldsRight($stopThisCarAtData, static::WIDTH/4, static::BASE_FIELD_HEIGHT/3);
        $waybillDateData = Data::createAtFieldsRight($waybillDate, static::WIDTH/4, static::BASE_FIELD_HEIGHT/3);
        $waybillNumber = Header::createAtFieldsBottom($waybillDate, static::WIDTH/4, static::BASE_FIELD_HEIGHT/3);
        $waybillNumberData = Data::createAtFieldsRight($waybillNumber, static::WIDTH/4, static::BASE_FIELD_HEIGHT/3);

        $to = Header::createAtFieldsBottom($stopThisCarAt2, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $toData = Data::createAtFieldsBottom($to, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);
        $from = Header::createAtFieldsRight($to, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $fromData = Data::createAtFieldsBottom($from, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);

        $consignee = Header::createAtFieldsBottom($toData, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $consigneeData = Data::createAtFieldsBottom($consignee, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);
        $shipper = Header::createAtFieldsRight($consignee, static::WIDTH/2, static::BASE_FIELD_HEIGHT/static::BASE_FIELD_HEIGHT_SLICES);
        $shipperData = Data::createAtFieldsBottom($shipper, static::WIDTH/2, static::BASE_FIELD_HEIGHT*(static::BASE_FIELD_HEIGHT_SLICES-1)/static::BASE_FIELD_HEIGHT_SLICES);


        $routeVia = Header::createAtFieldsBottom($consigneeData, static::WIDTH/4, static::BASE_FIELD_HEIGHT/2);
        $routeViaData = Data::createAtFieldsRight($routeVia, static::WIDTH*3/4, static::BASE_FIELD_HEIGHT/2);

        $instructionsAndExceptions = Header::createAtFieldsBottom($routeVia, static::WIDTH/3, static::BASE_FIELD_HEIGHT/3);
        $instructionsAndExceptionsData = Data::createAtFieldsRight($instructionsAndExceptions, static::WIDTH*2/3, static::BASE_FIELD_HEIGHT/3);

        $pkgs = Header::createAtFieldsBottom($instructionsAndExceptions, static::WIDTH/4, static::BASE_FIELD_HEIGHT/6);
        $pkgsData = Data::createAtFieldsBottom($pkgs, static::WIDTH/4, static::BASE_FIELD_HEIGHT*5/6 + static::BASE_FIELD_HEIGHT/3);
        $description = Header::createAtFieldsRight($pkgs, static::WIDTH*3/4, static::BASE_FIELD_HEIGHT/6);
        $descriptionData = Data::createAtFieldsRight($pkgsData, static::WIDTH*3/4, static::BASE_FIELD_HEIGHT*5/6 + static::BASE_FIELD_HEIGHT/3);

        $this->headerFields = [
            new DataField('FREIGHT WAYBILL', $formHeader),

            new DataField('WAYBILL DATE', $waybillDate),
            new DataField('WAYBILL NO.', $waybillNumber),

            new DataField('CAR INITIAL', $carInitial),
            new DataField('CAR NUMBER', $carNumber),
            new DataField('AAR CLASS OF CAR ORDERED', $aar),
            new DataField('LENGTH/CAPY OF CAR ORDERED', $len),
//            new DataField('DESC', $desc),
            new DataField('FROM   STATION   STATE', $from),
            new DataField('TO     STATION   STATE', $to),
            new DataField('SHIPPER', $shipper),
            new DataField('CONSIGNEE & ADDRESS', $consignee),
            new DataField('STOP THIS CAR AT', $stopThisCarAt),
            new DataField('AT', $stopThisCarAt2),
            new DataField('ROUTE/VIA', $routeVia),
            new DataField('INSTRUCTIONS & EXCEPTIONS', $instructionsAndExceptions),
            new DataField('# PKGS', $pkgs),
            new DataField('DESCRIPTION OF ARTICLES', $description),
        ];

        $this->dataFields = [
            new DataField(rand(10000, 90000), $waybillNumberData),
            new DataField((new \DateTime())->format('m/d/y'), $waybillDateData),

            new DataField('PRR', $carInitialData),
            new DataField('123456', $carNumberData),
            new DataField('XM', $aarData),
            new DataField('50', $lenData),

            new DataField($waybill->getFromAddress(), $fromData),
            new DataField($waybill->getToAddress(), $toData),
            new DataField($waybill->getShipper(), $shipperData),
            new DataField($waybill->getConsignee(), $consigneeData),
            new DataField($waybill->getSpotLocation(), $stopThisCarAtData),
            new DataField(null, $stopThisCarAt2Data),
            new DataField($waybill->getRouteVia(), $routeViaData),
            new DataField($waybill->getSpotLocation(), $instructionsAndExceptionsData),
            new DataField($waybill->getLadingQuantity(), $pkgsData),
            new DataField($waybill->getLadingDescription(), $descriptionData),

            new DataField(null, $marginLeft),
            new DataField(null, $marginRight),
        ];

        $verticalLines = [
            VerticalLine::createAtFieldRight($carInitialData),
            VerticalLine::createAtFieldRight($aarData),
            VerticalLine::createAtFieldRight($to),
            VerticalLine::createAtFieldRight($toData),
            VerticalLine::createAtFieldRight($consignee),
            VerticalLine::createAtFieldRight($consigneeData),
            VerticalLine::createAtFieldRight($stopThisCarAtData),
            VerticalLine::createAtFieldRight($stopThisCarAt2Data),
            VerticalLine::createAtFieldRight($marginLeft),
        ];
        $horizontalLines = [
            HorizontalLine::createAtFieldBottom($formHeader),

            HorizontalLine::createAtFieldBottom($waybillNumber),
            HorizontalLine::createAtFieldBottom($waybillNumberData),
            HorizontalLine::createAtFieldBottom($waybillDate),
            HorizontalLine::createAtFieldBottom($waybillDateData),

            HorizontalLine::createAtFieldBottom($carInitial),
            HorizontalLine::createAtFieldBottom($carInitialData),
            HorizontalLine::createAtFieldBottom($carNumber),
            HorizontalLine::createAtFieldBottom($carNumberData),
            HorizontalLine::createAtFieldBottom($marginLeft),
            HorizontalLine::createAtFieldBottom($marginRight),
            HorizontalLine::createAtFieldBottom($fromData),
            HorizontalLine::createAtFieldBottom($toData),
            HorizontalLine::createAtFieldBottom($shipperData),
            HorizontalLine::createAtFieldBottom($consigneeData),
            HorizontalLine::createAtFieldBottom($stopThisCarAt2),
            HorizontalLine::createAtFieldBottom($stopThisCarAt2Data),
            HorizontalLine::createAtFieldBottom($routeVia),
            HorizontalLine::createAtFieldBottom($routeViaData),
            HorizontalLine::createAtFieldBottom($instructionsAndExceptions),
            HorizontalLine::createAtFieldBottom($instructionsAndExceptionsData),
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