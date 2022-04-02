
# Hi & welcome! 👋


This project intends to to solve the challenge of providing a single GET endpoint to get 
a list of products. This list could also be filtered by query parameters.


## Things to consider

My PHP version is 7.4.16 and for this project I used the PHP built-in Web Server. \
To perform the tests, I'm using PHPUnit.



    
## Preparation

- Make sure that you have composer installed. If you don't, you can follow [these](https://getcomposer.org/doc/00-intro.md#installation-windows) instructions.

- Download PHPUnit using composer:

```bash
  composer global require --dev phpunit/phpunit ^9
```




## Run Locally

Clone the project

```bash
  git clone https://link-to-project
```

Go to the project directory

```bash
  cd Products Challenge
```

Start the server

```bash
   php -S localhost:8000
```

Perform a GET call to the /products endpoint. Examples:

- To get a list of products (only 5 results will show, but this can be changed in the getMaxAmountOfElementsToReturn function)

```bash
   /products
```

- To get a list of products filtered by category

```bash
   /products?category=boots
```

- To get a list of products filtered by price less than an amount.

```bash
   /products?priceLessThan=500
```
The current discounts are  set in the getCurrentDiscounts function. There are instructions to change and play with them.

You can take a look at the products.json file to see what categories are available and the price 
range of the products



## Running Tests

To run the tests

- First start the PHP server:

```bash
  php -S localhost:8000
```
- And then run the tests using:

```bash
  php ./vendor/phpunit/phpunit/phpunit UnitTestFiles/tests
```

Take you very much for taking your time to read this and taking a look at the code :)

