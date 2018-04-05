<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/6/18
 * Time: 3:15 PM
 */

namespace App\Paperwork\Line;


abstract class BaseLine implements LineInterface
{
    private $left;
    private $top;
    private $width;
    private $height;

    /**
     * @param float $left
     * @param float $top
     * @param float $width
     * @param float $height
     */
    public function __construct(float $left, float $top, float $width, float $height)
    {
        $this->left = $left;
        $this->top = $top;
        $this->width = $width;
        $this->height = $height;
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
    public function getTop(): float
    {
        return $this->top;
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

    abstract function getType(): string;
}