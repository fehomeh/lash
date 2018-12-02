<?php

namespace Lash\Infrastructure\Persistence\MySQL\Product;

use Illuminate\Database\DatabaseManager;
use Lash\Domain\Product\Entity\Product;
use Lash\Domain\Product\Exception\ProductNotFoundException;
use Lash\Domain\Product\ProductRepositoryInterface;
use Lash\Domain\Product\ValueObject\Size;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Product repository implementation using MySQL RDBMS.
 */
class MySQLProductRepository implements ProductRepositoryInterface
{
    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * MySQLProductRepository constructor.
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @inheritdoc
     */
    public function findBy(string $productType, string $color, Size $size): ?Product
    {
        $productData = $this->db->selectOne(
            'SELECT `uuid`, `product_type`, `price`, `color`, `size` FROM `product`'
            . ' WHERE `product_type` = ? AND `size` = ? AND `color` = ?',
            [
                $productType,
                $size->toString(),
                $color
            ]
        );

        if ($productData) {
            return $this->fromDBRow($productData);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function save(Product $product): void
    {
        $this->db->insert(
            'INSERT INTO `product`(`uuid`, `product_type`, `price`, `color`, `size`) VALUES (?,?,?,?,?)',
            [
                $product->getId(),
                $product->getProductType(),
                $product->getPrice(),
                $product->getColor(),
                $product->getSize()->toString()
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getById(UuidInterface $uuid): Product
    {
        $productData = $this->db->selectOne(
            'SELECT `uuid`, `product_type`, `price`, `color`, `size` FROM `product` WHERE `uuid` = ?',
            [
                $uuid->toString(),
            ]
        );

        if (!$productData) {
            throw new ProductNotFoundException(sprintf('Product with UUID "%s" not found.', $uuid));
        }

        return $this->fromDBRow($productData);
    }

    /**
     * @inheritdoc
     */
    public function getByType(string $productType): Product
    {
        $productData = $this->db->selectOne(
            'SELECT `uuid`, `product_type`, `price`, `color`, `size` FROM `product` WHERE `product_type` = ?',
            [
                $productType,
            ]
        );

        if (!$productData) {
            throw new ProductNotFoundException(sprintf('Product of type "%s" not found.', $productType));
        }

        return $this->fromDBRow($productData);
    }

    /**
     * @param \stdClass $productData
     *
     * @return Product
     */
    private function fromDBRow(\stdClass $productData): Product
    {
        return new Product(
            Uuid::fromString($productData->uuid),
            $productData->price,
            $productData->product_type,
            $productData->color,
            new Size($productData->size)
        );
    }
}
