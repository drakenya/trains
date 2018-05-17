<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/10/18
 * Time: 10:27 PM
 */

namespace App\Paperwork\Creator;


use App\Entity\Waybill;
use App\Paperwork\DataField;
use App\Paperwork\Field\BaseField;
use App\Paperwork\Field\Data;
use App\Paperwork\Field\FieldInterface;
use App\Paperwork\Field\FormType;
use App\Paperwork\Field\Header;
use App\Paperwork\Form\WaybillForm;
use App\Paperwork\Line\HorizontalLine;
use App\Paperwork\Line\VerticalLine;
use App\Paperwork\Page\FullWaybillPage;
use JMS\Serializer\SerializerInterface;

class ShortWaybillFormCreator
{
    /** @var FieldSpecification[] */
    private $fieldData;
    /** @var LineSpecification[] */
    private $lines;
    private $headerLabels;

    private $fields = [];

    public function __construct(SerializerInterface $serializer, array $fieldData, ?array $lines, array $headerLabels)
    {
        $this->headerLabels = $headerLabels;

        foreach ($fieldData as $fieldDatum) {
            /** @var FieldSpecification $field */
            $field = $serializer->deserialize(json_encode($fieldDatum), FieldSpecification::class, 'json');
            $this->fieldData[$field->getId()] = $field;
        }

        foreach ($lines as $line) {
            $this->lines[] = $serializer->deserialize(json_encode($line), LineSpecification::class, 'json');
        }
    }

    /**
     * @param array  $fields
     * @param string|BaseField $class
     * @param FieldSpecification  $fieldData
     *
     * @return FieldInterface
     */
    protected function createField(array $fields, string $class, FieldSpecification $fieldData): FieldInterface
    {
        switch ($fieldData->getPosition()) {
            case 'origin':
                return new $class(
                    $fieldData->getId(),
                    0,
                    0,
                    (new FullWaybillPage())->getItemWidth() * $fieldData->getWidth(),
                    WaybillForm::BASE_FIELD_HEIGHT * $fieldData->getHeight()
                );
            case 'right':
                return $class::createAtFieldsRight(
                    $fields[$fieldData->getReference()],
                    $fieldData->getId(),
                    (new FullWaybillPage())->getItemWidth() * $fieldData->getWidth(),
                    WaybillForm::BASE_FIELD_HEIGHT * $fieldData->getHeight()
                );
            case 'bottom':
                return $class::createAtFieldsBottom(
                    $fields[$fieldData->getReference()],
                    $fieldData->getId(),
                    (new FullWaybillPage())->getItemWidth() * $fieldData->getWidth(),
                    WaybillForm::BASE_FIELD_HEIGHT * $fieldData->getHeight()
                );
        }

        throw new UnknownLocationException($fieldData->getPosition());
    }

    /**
     * @param string  $key
     * @param Waybill $waybill
     *
     * @return null|string
     */
    private function getValueByKey(string $key, Waybill $waybill): ?string
    {
        if (isset($this->headerLabels[$key])) {
            return $this->headerLabels[$key];
        }

        switch ($key) {
            case 'consigneeData': return $waybill->getConsignee() ? $waybill->getConsignee()->getName() : null;
            case 'descriptionData': return $waybill->getLadingDescription();
            case 'fromData': return $waybill->getShipper() ? sprintf(
                '%s, %s',
                $waybill->getShipper()->getLocation()->getStationName(),
                $waybill->getShipper()->getLocation()->getState()
            ) : null;
            case 'instructionsAndExceptionsData': return $waybill->getInstructionsExceptions();
            case 'marginLeft': return null;
            case 'marginRight': return null;
            case 'pkgsData': return $waybill->getLadingQuantity();
            case 'routeViaData': return $waybill->getRouteVia();
            case 'shipperData': return $waybill->getShipper() ? $waybill->getShipper()->getName() : null;
            case 'stopThisCarAt2Data': return $waybill->getStopAt2();
            case 'stopThisCarAtData': return $waybill->getStopAt();
            case 'toData': return $waybill->getConsignee() ? sprintf(
                '%s, %s',
                $waybill->getConsignee()->getLocation()->getStationName(),
                $waybill->getConsignee()->getLocation()->getState()
            ) : null;
            case 'waybillDateData': return $waybill->getUpdatedAt()->format('m/d/y');
            case 'waybillNumberData': return $waybill->getId();
        }

        throw new UnknownDataKeyException($key);
    }

    private function loadFields(): void
    {
        foreach ($this->fieldData as $key => $field) {
            switch ($field->getType()) {
                case 'formHeader':
                    $class = FormType::class;
                    break;
                case 'header':
                    $class = Header::class;
                    break;
                case 'data':
                    $class = Data::class;
                    break;
                default:
                    throw new UnknownFieldType($field->getType());
            }

            $this->fields[$key] = $this->createField($this->fields, $class, $field);
        }
    }

    public function create(Waybill $waybill): WaybillForm
    {
        if (empty($this->fields)) {
            $this->loadFields();
        }

        $fields = [];
        foreach ($this->fields as $key => $field) {
            $fields[$key] = new DataField($this->getValueByKey($key, $waybill), $field);
        }

        $lines = [];
        foreach ($this->lines as $lineSpecification) {
            switch ($lineSpecification->getType()) {
                case 'vertical':
                    $class = VerticalLine::class;
                    break;
                case 'horizontal':
                    $class = HorizontalLine::class;
                    break;
                default:
                    throw new UnknownLineException($lineSpecification->getType());
            }

            /** @var HorizontalLine|VerticalLine $class */

            switch ($lineSpecification->getPosition()) {
                case 'right':
                    $lines[] = $class::createAtFieldRight($this->fields[$lineSpecification->getReference()]);
                    break;
                case 'bottom':
                    $lines[] = $class::createAtFieldBottom($this->fields[$lineSpecification->getReference()]);
                    break;
                default:
                    throw new UnknownLineException($lineSpecification->getPosition());
            }
        }

        return new WaybillForm(array_values($fields), $lines);
    }
}