<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/3/18
 * Time: 11:10 AM
 */

namespace App\Paperwork\Field;


abstract class BaseField implements FieldInterface
{
    private $id;
    private $left;
    private $top;
    private $width;
    private $height;

    public static function createAtFieldsRight(BaseField $field, string $id, float $width, float $height)
    {
        return new static($id, $field->getRight(), $field->getTop(), $width, $height);
    }

    public static function createAtFieldsBottom(BaseField $field, string $id, float $width, float $height)
    {
        return new static($id, $field->getLeft(), $field->getBottom(), $width, $height);
    }

    /**
     * Field constructor.
     *
     * @param string $id
     * @param float $left
     * @param float $top
     * @param float $width
     * @param float $height
     */
    public function __construct(string $id, float $left, float $top, float $width, float $height)
    {
        $this->id = $id;
        $this->left = $left;
        $this->top = $top;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getLeft(): float
    {
        return $this->left;
    }

    /**
     * @return float
     */
    public function getRight(): float
    {
        return $this->left + $this->width;
    }

    /**
     * @return float
     */
    public function getTop(): float
    {
        return $this->top;
    }

    /**
     * @return float
     */
    public function getBottom(): float
    {
        return $this->top + $this->height;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }
}