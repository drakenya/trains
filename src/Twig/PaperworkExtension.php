<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/5/18
 * Time: 8:55 PM
 */

namespace App\Twig;

use App\Paperwork\Field\FieldInterface;
use App\Paperwork\Field\FieldTypes;
use App\Paperwork\Line\BaseLine;
use App\Paperwork\Line\LineTypes;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaperworkExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('class_for_field', [$this, 'classForField']),
            new TwigFilter('field_label_for_print', [$this, 'fieldLabelForPrint']),
            new TwigFilter('class_for_line', [$this, 'classForLine']),
        ];
    }

    public function classForField(FieldInterface $field): ?string
    {
        switch ($field->getType()) {
            case FieldTypes::FORM_TYPE:
                return 'form_header'; break;
            case FieldTypes::HEADER:
                return 'field_header'; break;
            case FieldTypes::DATA:
                return 'field_data'; break;
            default:
                return null; break;
        }
    }

    public function classForLine(BaseLine $line): ?string
    {
        switch ($line->getType()) {
            case LineTypes::VERTICAL:
                return 'vline'; break;
            case LineTypes::HORIZONTAL:
                return 'hline'; break;
            default:
                return null; break;
        }
    }

    public function fieldLabelForPrint(?string $data): ?string
    {
        if (empty($data)) {
            return null;
        }

        $data = strtoupper($data);
        $data = str_replace('1', 'l', $data);
        $data = str_replace('0', 'O', $data);

        return $data;
    }
}