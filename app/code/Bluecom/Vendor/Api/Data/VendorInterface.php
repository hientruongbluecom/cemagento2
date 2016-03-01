<?php
namespace Bluecom\Vendor\Api\Data;

interface VendorInterface
{
    const NAME  = 'name';

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);
}