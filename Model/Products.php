<?php

class Products {

    /**
     * The base product list
     */
    public $product_list;

    public function __construct() {
        $this->product_list = file_get_contents(__DIR__ . '\..\products.json');
        $this->product_list = json_decode($this->product_list, TRUE);
    }

    /**
     * Function to get a list of products (5 results at most. This can be changed in getMaxAmountOfElementsToReturn)
     * @return mixed the products list
     */
    public function getProducts() {
        $prod_list = [];

        foreach ($this->product_list['products'] as $product) {

            $product['price'] = $this->getPriceStructure($product['price']);
            $prod_list[] = $product;
        }

        return $this->applyCurrentDiscounts($prod_list);
    }

    /**
     * Function to get a list of products based on category.
     *
     * @param string $category the category of the product (boots, dresses, sandals, etc)
     * @return array the products list filtered by category
     */
    public function getProductsByCategory($category) {
        $products_by_category = [];

        foreach ($this->product_list['products'] as $product) {

            if ($product['category'] == $category) {

                $product['price'] = $this->getPriceStructure($product['price']);
                $products_by_category[] = $product;
            }
        }

        return $this->applyCurrentDiscounts($products_by_category);

    }

    /**
     * Function to get a list of products based on price less than a certain amount.
     *
     * @param string $price_less_than the price to look for products under that amount
     * @return array the products list filtered by price
     */
    public function getProductsByPriceLessThan($price_less_than) {
        $products_by_price = [];
        $price_less_than = sprintf("%0.2f", $price_less_than);
        $price_less_than = str_replace('.', '', $price_less_than);

        foreach ($this->product_list['products'] as $product) {

            if (($product['price'] <= intval($price_less_than))) {

                $product['price'] = $this->getPriceStructure($product['price']);
                $products_by_price[] = $product;
            }
        }

        return $this->applyCurrentDiscounts($products_by_price);

    }

    /**
     * Function to get the current discounts available. (I've hardcoded the two that are required by
     * this challenge.)
     *
     * @return array with the current discounts available
     */
    public function getCurrentDiscounts() {

        //Assuming that there can only be two discounts available at most at a time (Category Eg. boots, dresses,
        // sandals & Others Eg. Sku, Name or Price)
        //The category section can have several categories at a time.

        return [
            'category' => [
                'boots' => 30,
                //Other categories and their discounts can be *ADDED* to the section
                /*'sneakers' => 15,
                'dresses' => 20*/
            ],
            'sku' => [
                '000003' => 15,
            ],
            //The sku discount can be *REPLACED* by another discount. Eg.
            /*'name' => [
                'Tropicana floral linen minidress' => 40,
            ],*/
        ];
    }

    /**
     * Function to get the price structure to add to each product
     * @param $price
     * @return array with the price section structure
     */
    public function getPriceStructure($price) {
        return [
            'original' => $price,
            'final' => $price,
            'discount_percentage' => null,
            'currency' => 'EUR',
        ];
    }

    /**
     * Function to get the number for the maximum amount of results.
     *
     * @return int indicating the max amount of results
     */
    public function getMaxAmountOfElementsToReturn() {
        return 5;
    }

    /**
     * Function to apply the available discounts to a product list.
     *
     * @param array $product_list the list of the products
     *
     * @return array with the filtered products
     */
    public function applyCurrentDiscounts($product_list) {
        $filtered_product_list = [];
        $counter = 0;
        $category_discount = 0;
        $other_discount = 0;
        $current_discounts = $this->getCurrentDiscounts();
        $max_amount_of_results = $this->getMaxAmountOfElementsToReturn();

        if (array_key_exists('category', $current_discounts)) {
            $category_discount = $current_discounts['category'] ?? $category_discount;
            unset($current_discounts['category']);
        }

        $other_discount = $current_discounts ?? $other_discount;

        //Applying the discounts
        foreach ($product_list as $item) {

            if (in_array($item['category'], array_keys($category_discount))) {

                $item['discounts'][] = $category_discount[$item['category']];
            }

            $other_discount_name = array_key_first($other_discount);

            if (in_array($other_discount_name, array_keys($item))) {

                if ($item[$other_discount_name] == array_key_first($other_discount[$other_discount_name])) {

                    $item['discounts'][] = $other_discount[$other_discount_name][$item[$other_discount_name]];
                }
            }

            //Obtaining the biggest discount
            $discount_to_apply = !empty($item['discounts']) ? max($item['discounts']) : 0;

            if (!empty($discount_to_apply)) {

                $value_to_discount = ceil(($item['price']['original'] * $discount_to_apply) / 100);
                $new_discounted_price = $item['price']['original'] - $value_to_discount;
                $item['price']['final'] = $new_discounted_price;
                $item['price']['discount_percentage'] = $discount_to_apply . '%';
                unset($item['discounts']);
            }

            $filtered_product_list[] = $item;

            //Counter to keep track of the iteration number to stop at the max amount of results number.
            $counter++;

            if($counter == $max_amount_of_results) {
                break;
            }
        }

        return [
            'products' => $filtered_product_list,
        ];
    }
}