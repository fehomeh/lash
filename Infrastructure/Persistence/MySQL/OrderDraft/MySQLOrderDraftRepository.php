<?php

namespace Lash\Infrastructure\Persistence\MySQL\OrderDraft;

use Illuminate\Database\DatabaseManager;
use Lash\Domain\Order\Entity\OrderDraft;
use Lash\Domain\Order\OrderDraftRepositoryInterface;

class MySQLOrderDraftRepository implements OrderDraftRepositoryInterface
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
    public function save(OrderDraft $orderDraft): void
    {
        $this->db->transaction(
            function () use ($orderDraft) {
                $this->db->insert(
                    'INSERT INTO `order_draft`(`uuid`, `country_code`) VALUES (?, ?);',
                    [$orderDraft->getId(), $orderDraft->getCountryCode()]
                );
                $products = $orderDraft->getProducts();
                foreach ($products as $product) {
                    $this->db->insert(
                        'INSERT INTO `order_draft__product`(`order_uuid`, `product_uuid`, `quantity`) VALUES (?, ?, ?)',
                        [
                            $orderDraft->getId(),
                            $product->getId(),
                            $products->getInfo(),
                        ]
                    );
                }
            }
        );
    }
}
