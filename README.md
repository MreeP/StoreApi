<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation
1. Adjust `.env` file

2. Install composer dependencies:
```shell
composer install
```
3. Please use sail to perform docker installation. Create alias:
```shell
sail vendor/bin/sail
```
4. Setup docker environment
```shell
sail up
sail artisan migrate --seed
```

Default admin is `admin@admin.com:password` 

## Endpoints
| Path | Method | Parameters | Description |
|---|---|---|---|
| /api/login | GET | email, password | Generates new api token |
| /api/logout | GET | token | Revokes api tokens |
| /api/products | GET | [token] | List active products |
| /api/products/{id} | GET | [token] | Get product details |
| /api/products/{id} | DELETE | token | Delete product |
| /api/products | POST | token, name, [description], [details], [active], [sale] | Add new product |
| /api/products/{id} | PATCH | token, [name], [description], [details], [active], [sale] | Update product details |
| /api/prices/{id} | GET | token | Get price details |
| /api/prices/{id} | DELETE | token | Delete price |
| /api/prices | POST | token, [product_id], [variant], [value], [active] | Add new price |
| /api/prices/{id} | PATCH | token, [product_id], [variant], [value], [active] | Update price details |

`/api/products:GET` supports following query string arguments:
- asc=[0/1] determines sorting direction
- sortby=[name/id] determines sorting column
- onSale=[0/1] filters `sale` column
- search=[term] searches for a term in name, description and details

example `/api/products?sortby=id&asc=0&onSale=1`

## Testing
```
sail artisan test
```

## Shell snippets to access endpoints
Login
```shell
curl --request POST \
  --url http://localhost/api/login \
  --header 'Content-Type: application/json' \
  --data '{
	"email": "admin@admin.com",
	"password": "password"
}'
```

Substitute `TOKEN` with result of the above request.

Logout
```shell
curl --request POST \
  --url http://localhost/api/logout \
  --header 'Content-Type: application/json' \
  --data '{
	"token": "TOKEN"
}'
```
List products
```shell
curl --request GET \
  --url http://localhost/api/products \
  --header 'Content-Type: application/json' \
  --data '{
	"token":"TOKEN"
}'
```
Product with details
```shell
curl --request GET \
  --url http://localhost/api/products/1 \
  --header 'Content-Type: application/json' \
  --data '{
	"token":"TOKEN"
}'
```
Create product
```shell
curl --request POST \
  --url http://localhost/api/products/ \
  --header 'Content-Type: application/json' \
  --data '{
	"token":"TOKEN",
	"name": "new",
	"description": "sth new",
	"details": "{\"ASD\": 123,\"FGH\": 456}",
	"active": true,
	"sale": false
}'
```
Update product
```shell
curl --request PATCH \
  --url http://localhost/api/products/1 \
  --header 'Content-Type: application/json' \
  --data '{
	"token": "TOKEN",
	"name": "nowa_nazwa",
	"sale": true
}'
```
Delete product
```shell
curl --request DELETE \
  --url http://localhost/api/products/2 \
  --header 'Content-Type: application/json' \
  --data '{
	"token":"TOKEN"
}'
```
Price with details
```shell
curl --request GET \
--url http://localhost/api/prices/1 \
--header 'Content-Type: application/json' \
--data '{
"token":"TOKEN"
}'
```
Create price
```shell
curl --request POST \
  --url http://localhost/api/prices/ \
  --header 'Content-Type: application/json' \
  --data '{
	"token": "TOKEN",
	"product_id": 1,
	"variant": "red",
	"value": "123.32",
	"active": true
}'
```
Update price
```shell
curl --request PATCH \
  --url http://localhost/api/prices/1 \
  --header 'Content-Type: application/json' \
  --data '{
	"token": "TOKEN",
	"product_id": 2
}'
```
Delete price
```shell
curl --request DELETE \
  --url http://localhost/api/prices/2 \
  --header 'Content-Type: application/json' \
  --data '{
	"token": "TOKEN"
}'
```
