<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/11/18
 * Time: 10:23 AM
 */

namespace App\Paperwork\Creator;

use JMS\Serializer\Annotation as Serializer;

class LineSpecification
{
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
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $reference;

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

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}