# CakePHP требования к окружению:

https://book.cakephp.org/3.0/en/installation.html#requirements

# Пререквизиты

Из корня проекта, установка зависимостей
```sh
$ composer install
```
Дать полные права на logs,tmp
```sh
$ sudo chmod 777 -R {logs,tmp}
```
Создание БД
```sh
mysql> CREATE DATABASE minenko_konstantin DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
mysql> GRANT ALL PRIVILEGES ON minenko_konstantin.* TO minenko_konstantin@localhost IDENTIFIED BY 'minenko_konstantin';
```
Накатить миграции и сиды, из корня проекта выполнить
```sh
bin/cake migrations migrate
bin/cake migrations seed
```

# Комментарии по проекту
Из .gitignore config/app.php я убрал, он есть в проекте. Сделал специально, чтобы ускорить настройку окружения, там уже прописаны доступы к БД.

# Ответы \ Комментарии к тестированию

##### Задание 1
###### 1)
```sql
SELECT DISTINCT application.*, IF(credit.client_id IS NOT NULL, false, true) AS 'new_client'
FROM application
LEFT JOIN credit ON application.client_id = credit.client_id
ORDER BY application.id
```
###### 2) Тут не уточнено , но скорее всего, под "ID предыдущего кредита" подразумевается "ID предыдущего кредита клиента"
```sql
SELECT *, (
    SELECT id
    FROM credit prev_credit
    WHERE prev_credit.client_id = cur_credit.client_id AND prev_credit.id < cur_credit.id
    ORDER BY id DESC
    LIMIT 1
) AS 'previous_credit_id'
FROM credit cur_credit
ORDER BY cur_credit.id
```

##### Задание 2
Из корня проекта
```sh
bin/cake money_transfer  // помощь
bin/cake money_transfer 1 2 100  // пример использования
```
- `Первый аргумент` - id пользователя из таблицы users. Отправитель. При успешной транзакции поле wallet_amount измениться на wallet_amount-amount (amount -`третий аргумент`)
- `Второй аргумент` - id пользователя из таблицы users. Получатель. При успешной транзакции поле wallet_amount измениться на wallet_amount+amount (amount - `третий аргумент`)
- `Третий аргумент` - сумма перевода

Логика лежит в
```sh
src/Shell/MoneyTransferShell.php
```

##### Задание 3
https://jsfiddle.net/killmegerty/2sx738pd/

Решил не использовать какие-либо либы \ фреймворки.
