# API_delivery

Api для работы с доставкой товара.
Возвращает значения в формате json.

calculate.php - Расчет стоимости доставки.

delivery.php - Создание заказа.

info.php - Информация о заказе.

orders.php - Информация о всех заказах.


# Installation

Для установки тестовой базы данных внутри папки v1 выполнить команду:
<pre>
php Install.php
</pre>
Создается база данных - api_db.

Таблицы - api, products, delivery.

# Usage

### Расчет стоимости доставки.
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
POST /v1/calculate HTTP/1.1
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

### Создать заказ.

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
POST /v1/delivery HTTP/1.1
Host: localhost
Client-Id: 521
Api-Key: 7dbb8d6e
Content-Type: application/json

{
    "name" => "Name",
    "phone" => "123456789",
    "product_id" => "16",
    "destination" => "ул. белозерская 19",
    "date_delivery" => "2020-07-21"
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