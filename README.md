# API_delivery

Api для работы с доставкой товара.
Возвращает значения в формате json.

calculate.php - Расчет стоимости доставки.

delivery.php - Создание заказа.

info.php - Информация о заказе.

orders.php - Информация о всех заказах.

post.php - файл для тестов


# Installation

Для установки тестовой базы данных внутри папки v1 выполнить команду:
<pre>
php Install.php
</pre>
Создается база данных - api_db.

Таблицы - api, products, delivery.

# Usage

### Расчет стоимости доставки
**Параметры запроса:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Обязательный
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
product_id
</td>
<td>
int
</td>
<td>
Да
</td>
<td>
Идентификатор товара.
</td>
</tr>
</tbody>
</table>

**Параметры ответа:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
result
</td>
<td>
int
</td>
<td>
Стоимость доставки
</td>
</tr>
</tbody>
</table>

#### Пример запроса:
<pre>
POST /v1/calculate.php HTTP/1.1
Host: localhost
Client-Id: 521
Api-Key: 7dbb8d6e
Content-Type: application/json

{
  "product_id": 15
}
</pre>

#### Пример ответа:
<pre>
{"result":200}
</pre>

### Создать заказ

**Параметры запроса:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Обязательный
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
product_id
</td>
<td>
int
</td>
<td>
Да
</td>
<td>
Идентификатор товара.
</td>
</tr>
<tr>
<td>
destination
</td>
<td>
string
</td>
<td>
Да
</td>
<td>
Пунк назначения.
</td>
</tr>
<tr>
<td>
phone
</td>
<td>
int
</td>
<td>
Да
</td>
<td>
Контактный номер.
</td>
</tr>
<tr>
<td>
name
</td>
<td>
string
</td>
<td>
Да
</td>
<td>
Имя получателя.
</td>
</tr>
<tr>
<td>
date_delivery
</td>
<td>
date
</td>
<td>
Да
</td>
<td>
Дата доставки.
</td>
</tr>
</tbody>
</table>

**Параметры ответа:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
result
</td>
<td>
array
</td>
<td>
Информация о заказе.
</td>
</tr>
<tr>
<td>
success
</td>
<td>
boolean
</td>
<td>
Статус создания заказа.
</td>
</tr>
<tr>
<td>
order_id
</td>
<td>
int
</td>
<td>
Номер заказа.
</td>
</tr>
</tbody>
</table>

#### Пример запроса:
<pre>
POST /v1/delivery.php HTTP/1.1
Host: localhost
Client-Id: 521
Api-Key: 7dbb8d6e
Content-Type: application/json

{
    "name": "Name",
    "phone": "123456789",
    "product_id": "16",
    "destination": "ул. street 19",
    "date_delivery": "2020-07-21"
}
</pre>

#### Пример ответа:
<pre>
{
    "result":
    {
        "success":true,
        "order_id":"48"
     }
}
</pre>


### Получить список заказов

**Параметры запроса:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Обязательный
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
dir
</td>
<td>
str
</td>
<td>
Да
</td>
<td>
Направление сортировки:
<ul>
<li>asc — по возрастанию.</li>
<li>desc — по убыванию.</li></ul>
</td>
</tr>
<tr>
<td>
filter
</td>
<td>
array
</td>
<td>
Нет
</td>
<td>
Фильтр для поиска отправлений.
</td>
</tr>
<tr>
<td>
since
</td>
<td>
datetime
</td>
<td>
Да
</td>
<td>
Начало периода в формате YYYY-MM-DD.
</td>
</tr>
<tr>
<td>
to
</td>
<td>
datetime
</td>
<td>
Да
</td>
<td>
Конец периода в формате YYYY-MM-DD.
</td>
</tr>
<tr>
<td>
limit
</td>
<td>
int
</td>
<td>
Да
</td>
<td>
Количество отправлений в ответе. Минимум — 1.
</td>
</tr>
</tbody>
</table>

**Параметры ответа:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
order_date_create
</td>
<td>
datetime
</td>
<td>
Дата создания заказа.
</td>
</tr>
<tr>
<td>
order_delivery
</td>
<td>
datetime
</td>
<td>
Дата доставки.
</td>
</tr>
<tr>
<td>
product_id
</td>
<td>
int
</td>
<td>
id товара
</td>
</tr>
<tr>
<td>
phone
</td>
<td>
int
</td>
<td>
Контактный номер получателя.
</td>
</tr>
<tr>
<td>
client_name
</td>
<td>
string
</td>
<td>
Имя получателя.
</td>
</tr>
<tr>
<td>
destination
</td>
<td>
string
</td>
<td>
Пункт назначения.
</td>
</tr>
<tr>
<td>
order_id
</td>
<td>
int
</td>
<td>
Номер заказа.
</td>
</tr>
<tr>
<td>
quantity
</td>
<td>
int
</td>
<td>
Количество товара.
</td>
</tr>
<tr>
<td>
product_name
</td>
<td>
int
</td>
<td>
Название товара.
</td>
</tr>
<tr>
<td>
price
</td>
<td>
int
</td>
<td>
Цена товара.
</td>
</tr>
</tbody>
</table>

#### Пример запроса:
<pre>
POST /v1/orders.php HTTP/1.1
Host: localhost
Client-Id: 521
Api-Key: 7dbb8d6e
Content-Type: application/json

{
    "dir": "asc",
    "filter": [
                "since": "2020-07-20",
                "to": "2020-08-30"
               ]
    "limit": 2
}
</pre>

#### Пример ответа:
<pre>
{
    "result":[
        {
            "order_date_create": "2020-07-20",
            "order_delivery": "2020-07-21",
            "product_id": "16",
            "phone": "123456789",
            "client_name": "Name",
            "destination": "ул. street 19",
            "order_id": "24",
            "quantity": "1",
            "product_name": "Samsung Galaxy M31",
            "price": "19990"
        },
        {
            "order_date_create": "2020-07-20",
            "order_delivery": "2020-07-21",
            "product_id": "16",
            "phone": "123456789",
            "client_name": "Name",
            "destination": "ул. street 19",
            "order_id": "16",
            "quantity": "1",
            "product_name": "Samsung Galaxy M31",
            "price": "19990"
            }
                ]
}
</pre>


### Получить информацию о заказе

**Параметры запроса:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Обязательный
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
order_id
</td>
<td>
int
</td>
<td>
Да
</td>
<td>
Номер заказа.
</td>
</tbody>
</table>

**Параметры ответа:**
<table>
<tbody>
<tr>
<th>
Параметр
</th>
<th>
Тип
</th>
<th>
Описание
</th>
</tr>
<tr>
<td>
order_date_create
</td>
<td>
datetime
</td>
<td>
Дата создания заказа.
</td>
</tr>
<tr>
<td>
order_delivery
</td>
<td>
datetime
</td>
<td>
Дата доставки.
</td>
</tr>
<tr>
<td>
product_id
</td>
<td>
int
</td>
<td>
id товара
</td>
</tr>
<tr>
<td>
phone
</td>
<td>
int
</td>
<td>
Контактный номер получателя.
</td>
</tr>
<tr>
<td>
client_name
</td>
<td>
string
</td>
<td>
Имя получателя.
</td>
</tr>
<tr>
<td>
destination
</td>
<td>
string
</td>
<td>
Пункт назначения.
</td>
</tr>
<tr>
<td>
order_id
</td>
<td>
int
</td>
<td>
Номер заказа.
</td>
</tr>
<tr>
<td>
quantity
</td>
<td>
int
</td>
<td>
Количество товара.
</td>
</tr>
<tr>
<td>
product_name
</td>
<td>
int
</td>
<td>
Название товара.
</td>
</tr>
<tr>
<td>
price
</td>
<td>
int
</td>
<td>
Цена товара.
</td>
</tr>
<tr>
<td>
sku
</td>
<td>
string
</td>
<td>
Артикул товара.
</td>
</tr>
<tr>
<td>
vendor
</td>
<td>
string
</td>
<td>
Производитель
</td>
</tr>
<tr>
<td>
images
</td>
<td>
string
</td>
<td>
Изображение товара
</td>
</tr>
<tr>
<td>
height
</td>
<td>
int
</td>
<td>
Высота упаковки.
</td>
</tr>
<tr>
<td>
width
</td>
<td>
int
</td>
<td>
Ширина упаковки.
</td>
</tr>
<tr>
<td>
weight
</td>
<td>
int
</td>
<td>
Вес товара в упаковке.
</td>
</tr>
</tbody>
</table>

#### Пример запроса:
<pre>
POST /v1/info.php HTTP/1.1
Host: localhost
Client-Id: 521
Api-Key: 7dbb8d6e
Content-Type: application/json

{
    "order_id": 64
}
</pre>

#### Пример ответа:
<pre>
{
    "result":
        {
            "order_date_create": "2020-07-21",
            "order_delivery": "2020-08-21",
            "product_id": "16",
            "phone": "123456789",
            "client_name": "Name4",
            "destination": "ул. street 19",
            "order_id": "64",
            "quantity": "1",
            "description": "Black Samsung Galaxy M31 with 128GB",
            "product_name": "Samsung Galaxy M31",
            "sku": "5722937",
            "vendor": "Samsung",
            "images": "",
            "price": "19990",
            "height": "90",
            "width": "160",
            "weight": "200"
        }
}
</pre>