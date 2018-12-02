## LaSh - simple REST API e-commerce shop example

LaSh stands for [Laravel](https://laravel.com) Shop.
This is a test application with several API RESTful methods.

## Requirements
- Latest [composer](https://getcomposer.org/)
- PHP >= 7.1.3
- MySQL >= 5.6

## Installation instructions

1. Copy `.env.example` file to `.env`:
```
cp ./.env.example ./.env
```
2. Fill out parameters in `.env` file
3. Install vendor libraries with composer:
```
composer install
```
4. Run tests:
```
./vendor/bin/phpunit
```
5. Execute migrations:
```
php artisan migrate
```

## API

### POST /api/product

**Important notice!** API allows only JSON requests. Therefore all requests must contain a header `Accept: application/json`.

**Description:** Creates new product. Returns UUID for created project ID.

**Restrictions:** Product must have unique type, color and size.

**Parameters:**

- price*:
    
    type: float
    
- product_type*:
    
    type: string
    
    Max length: 255
    
- size*:
    
    type: string
    
    Possible values: xs,s,m,l,xl,xxl,xxxl,xxxxl
    
- color*:
    
    type: string
    
    Max length: 30
    
### POST /order

Description: Creates new order draft from set of products with given quantities. Return total price of the order.
Restrictions: total order sum must be greater than or equal to 10.

- products*:
    
    type: array Where key is product UUID, and value is quantity
    
### GET /orders

Description: Returns list of all orders with their products.

### GET /orders/{product_type}

Description: Returns list of orders containing given product type.