<?php
declare(strict_types=1);
require_once __DIR__ . "\..\..\Model\Products.php";

use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase {

    /**
     * @var array[][] Expected result when calling /products
     */
    private $test_product_list = [
        'products' => [
            [
                'sku' => '000001',
                'name' => 'BV Lean leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 89000,
                    'final' => 62300,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000002',
                'name' => 'BV Lean leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 99000,
                    'final' => 69300,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000003',
                'name' => 'Ashlington leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 71000,
                    'final' => 49700,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000004',
                'name' => 'Naima embellished suede sandals',
                'category' => 'sandals',
                'price' => [
                    'original' => 79500,
                    'final' => 79500,
                    'discount_percentage' => NULL,
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000005',
                'name' => 'Nathane leather sneakers',
                'category' => 'sneakers',
                'price' => [
                    'original' => 59000,
                    'final' => 59000,
                    'discount_percentage' => NULL,
                    'currency' => 'EUR',
                ],
            ],
        ],
    ];

    /**
     * @var array[][] Expected result when calling /products?category=boots
     */
    private $test_product_by_category_list = [
        'products' => [
            [
                'sku' => '000001',
                'name' => 'BV Lean leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 89000,
                    'final' => 62300,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000002',
                'name' => 'BV Lean leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 99000,
                    'final' => 69300,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000003',
                'name' => 'Ashlington leather ankle boots',
                'category' => 'boots',
                'price' => [
                    'original' => 71000,
                    'final' => 49700,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000006',
                'name' => 'Billie leather knee-high boots',
                'category' => 'boots',
                'price' => [
                    'original' => 183000,
                    'final' => 128100,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000007',
                'name' => 'Shearling-lined leather Chelsea boots',
                'category' => 'boots',
                'price' => [
                    'original' => 120000,
                    'final' => 84000,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
        ],
    ];

    /**
     * @var array[][] Expected result when calling /products?priceLessThan=500
     */
    private $test_product_by_price_lees_than_list = [
        'products' => [
            [
                'sku' => '000009',
                'name' => 'Victoria cotton minidress',
                'category' => 'dresses',
                'price' => [
                    'original' => 26500,
                    'final' => 26500,
                    'discount_percentage' => NULL,
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000013',
                'name' => 'Loftgrip rubber rain boots',
                'category' => 'boots',
                'price' => [
                    'original' => 33500,
                    'final' => 23450,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
            [
                'sku' => '000015',
                'name' => 'Leather Chelsea boots',
                'category' => 'boots',
                'price' => [
                    'original' => 31900,
                    'final' => 22330,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
        ]
    ];

    /**
     * @var array[] Expected result when calling /products?category=foo
     * or /products?category=
     */
    private $test_product_by_wrong_or_empty_category_list = [
        'products' => []
    ];

    public function testCanGetListOfProducts() {
        $prodMod = new Products();

        $this->assertEquals(
            $this->test_product_list,
            $prodMod->getProducts());
    }

    public function testCanFilterByCategory() {
        $prodMod = new Products();

        $this->assertEquals(
            $this->test_product_by_category_list,
            $prodMod->getProductsByCategory('boots'));
    }

    public function testCanFilterByPriceLessThan() {
        $prodMod = new Products();

        $this->assertEquals(
            $this->test_product_by_price_lees_than_list,
            $prodMod->getProductsByPriceLessThan('500'));
    }

    public function testProductListWhenCategoryIsWrong() {
        $prodMod = new Products();

        $this->assertEquals(
            $this->test_product_by_wrong_or_empty_category_list,
            $prodMod->getProductsByCategory('foo'));
    }

    public function testProductListWhenCategoryIsEmpty() {
        $prodMod = new Products();

        $this->assertEquals(
            $this->test_product_by_wrong_or_empty_category_list,
            $prodMod->getProductsByCategory(''));
    }
}