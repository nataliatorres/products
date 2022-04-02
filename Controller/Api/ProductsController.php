<?php

require PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

class ProductsController extends BaseController {

    /**
     * Get list of products
     */
    public function listProducts() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $responseData = '';

        if (strtoupper($requestMethod) == 'GET') {

            try {

                $productModel = new Products();

                if (empty($arrQueryStringParams)) {

                    $responseData = json_encode($productModel->getProducts());
                }
                else {

                    //Querying products by priceLessThan
                    if (isset($arrQueryStringParams['priceLessThan']) && $arrQueryStringParams['priceLessThan']) {

                        $priceLessThan = $arrQueryStringParams['priceLessThan'];
                        $responseData = json_encode($productModel->getProductsByPriceLessThan($priceLessThan));
                    }
                    //Querying products by category
                    elseif (isset($arrQueryStringParams['category']) && $arrQueryStringParams['category']) {

                        $category = $arrQueryStringParams['category'];
                        $responseData = json_encode($productModel->getProductsByCategory($category));
                    }
                    else {
                        $strErrorDesc = 'Nothing found ';
                        $strErrorHeader = 'HTTP/1.1 404 Not Found';
                    }
                }
            }
            catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong. Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                ['Content-Type: application/json', 'HTTP/1.1 200 OK']
            );
        }
        else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]),
                ['Content-Type: application/json', $strErrorHeader]
            );
        }
    }

}