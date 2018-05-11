<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/11/18
 * Time: 10:23 AM
 */

namespace App\Paperwork\Creator;

use JMS\Serializer\Annotation as Serializer;

class FieldSpecification
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $type;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $position;

    /**
     * @var string|null
     *
     * @Serializer\Type("string")
     */
    private $reference;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     */
    private $width;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     */
    private $height;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    public function getReference(): ?string
    {
        return $this->reference;
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