<?php

namespace Lash\Domain\Product\Entity;

use Lash\Domain\Product\ValueObject\Size;
use Ramsey\Uuid\UuidInterface;

class Product
{
	/**
	 * @var UuidInterface
	 */
	private $id;

	/**
	 * @var float
	 */
	private $price;

	/**
	 * @var string
	 */
	private $productType;

	/**
	 * @var string
	 */
	private $color;

	/**
	 * @var Size
	 */
	private $size;

	/**
	 * Product constructor.
	 * @param UuidInterface $id
	 * @param float $price
	 * @param string $productType
	 * @param string $color
	 * @param Size $size
	 */
	public function __construct(UuidInterface $id, float $price, string $productType, string $color, Size $size)
	{
		$this->id = $id;
		$this->price = $price;
		$this->productType = $productType;
		$this->color = $color;
		$this->size = $size;
	}

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }
}
