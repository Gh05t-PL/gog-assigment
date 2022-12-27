# gog-assigment

## Requirements

- WSL/Linux
- docker
- docker-compose or docker compose plugin (newer versions)
- make

## First run

To run this repo just type following command in your terminal `make start`
## Data

| id                                   | Title         |
|--------------------------------------|---------------|
| 56c0f626-bcca-4a5e-96a8-d427c0ca96a8 | Fallout       |
| e43e3d2d-e972-470c-8c1e-3567c1b359da | Don’t Starve  |
| cf14b840-8091-4282-9072-382b6e820ad8 | Baldur’s Gate |
| 643f6762-f2db-4d7c-b739-1a60b06c6621 | Icewind Dale  |
| 5683a4e0-9b55-4244-a72b-1a1f6d4c3143 | Bloodborne    |
## Endpoints

### Create product
```bash
curl --location --request POST 'localhost/api/v1/product' \
--header 'Content-Type: application/json' \
--data-raw '{
    "title": "New Game",
    "price": 23.34
}'
```

### Delete product
```bash
curl --location --request DELETE 'localhost/api/v1/product/PRODUCT_ID' \
--header 'Content-Type: application/json'
```

### Update product
```bash
curl --location --request PUT 'localhost/api/v1/product/PRODUCT_ID' \
--header 'Content-Type: application/json' \
--data-raw '{
    "title": "New Gamne",
    "price": 23.34
}'
```

### List products
```bash
curl --location --request GET 'localhost/api/v1/product?page=1'
```

### Create shopping cart
```bash
curl --location --request POST 'localhost/api/v1/shopping-cart'
```

### Add product to shopping cart
```bash
curl --location --request POST 'localhost/api/v1/shopping-cart/CART_ID/product' \
--header 'Content-Type: application/json' \
--data-raw '{
    "productId": "ID",
    "quantity": 1
}'
```

### View shopping cart
```bash
curl --location --request GET 'localhost/api/v1/shopping-cart/CART_ID'
```

### Remove product from cart
```bash
curl --location --request DELETE 'localhost/api/v1/shopping-cart-line/d663640c-297e-4d22-8d7e-0926172503f6'
```
