<?php

namespace Lash\Infrastructure\Persistence\MySQL\OrderDraft;

use App\Repository\OrderListRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Lash\Domain\Product\Entity\Product;

class OrderListRepository implements OrderListRepositoryInterface
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
    public function findAll(): array
    {
        $sql = $this->makeBasicSQL();

        $orders = $this->db->select($sql);
        $result = [];
        foreach ($orders as $order) {
            $result[$order->uuid][] = $this->formatResultRow($order);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function findByProduct(Product $product): array
    {
        $sql = $this->makeBasicSQL();
        $sql = $this->appendWhereProductUuid($sql);

        $orders = $this->db->select($sql, [$product->getId()]);
        $result = [];
        foreach ($orders as $order) {
            $result[$order->uuid][] = $this->formatResultRow($order);
        }

        return $result;
    }

    /**
     * @return string
     */
    private function makeBasicSQL(): string
    {
        $sql = 'SELECT `od`.`uuid`, `od`.`country_code`, `odp`.`quantity`, `p`.`product_type`, `p`.`size`, `p`.`color` '
            . 'FROM `order_draft` od JOIN `order_draft__product` odp ON `odp`.`order_uuid`=`od`.`uuid` JOIN `product` p'
            . ' ON `odp`.`product_uuid` = `p`.`uuid`';

        return $sql;
    }

    /**
     * @param string $sql
     *
     * @return string
     */
    private function appendWhereProductUuid(string $sql): string
    {
        return $sql . ' WHERE `odp`.`order_uuid` IN (SELECT `odp2`.`order_uuid` FROM `order_draft__product` `odp2` WHERE `odp2`.product_uuid = ?)';
    }

    /**
     * @param \stdClass $order
     *
     * @return array
     */
    private function formatResultRow(\stdClass $order): array
    {
        return [
            'order_uuid' => $order->uuid,
            'country_code' => $order->country_code,
            'quantity' => $order->quantity,
            'product_type' => $order->product_type,
            'size' => $order->size,
            'color' => $order->color,
        ];
    }
}
