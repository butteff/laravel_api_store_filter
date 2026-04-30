English overview first, Russian overview at the end of this Readme.md file:

## How to test:

0. composer install
1. php artisan migrate:fresh --seed
2. php artisan optimize
3. php artisan serve
4. Открыть в браузере ссылку, например, http://127.0.0.1:8000/api/products?q=lg&sort=newest&price_from=111&category_id=1&in_stock=1

## The task

Eloquent search in products with filters
development of HTTP-endpoint (GET /api/products), which returns some list of products with filters and sorting, with pagination.

Product has these fields:
* id
* name (string, LIKE or FULLTEXT index, if you want)
* price (decimal)
* category_id (foreign key on categories)
* in_stock (boolean)
* rating (float, 0–5)
* created_at
* updated_at

Filters (query-params):
* q — search in name
* price_from, price_to
* category_id
* in_stock (true/false)
* rating_from

Sorting:
sort param with these values: price_asc, price_desc, rating_desc, newest.

Pagination is required

## Запуск проекта для теста:

0. composer install
1. php artisan migrate:fresh --seed
2. php artisan optimize
3. php artisan serve
4. Открыть в браузере ссылку, например, http://127.0.0.1:8000/api/products?q=lg&sort=newest&price_from=111&category_id=1&in_stock=1

## Техническое задание

Реализовать поиск по товарам с фильтрами
Реализовать HTTP-endpoint (например, GET /api/products), который возвращает список товаров с возможностью фильтрации и сортировки.

У товара должны быть поля:
* id
* name (string, индекс по LIKE или FULLTEXT если захочешь)
* price (decimal)
* category_id (foreign key на таблицу categories)
* in_stock (boolean)
* rating (float, 0–5)
* created_at
* updated_at

Фильтры (через query-параметры):
* q — поиск по подстроке в name
* price_from, price_to
* category_id
* in_stock (true/false)
* rating_from

Сортировка:
параметр sort с допустимыми значениями: price_asc, price_desc, rating_desc, newest.

Обязательна пагинация.