Первое задание было выполнено за 1 час 40 минут 
- создание проекта и настройка окружения (docker-compose) - 30 минут
- создание миграций и сидоров для наполнения таблиц - 45 минут
- написание запроса - 25 минут

```
SELECT users.id as UID,
       CONCAT(users.first_name, ' ', users.last_name) as Name,
       books.author as Author,
       GROUP_CONCAT(books.name SEPARATOR ', ') as Books
FROM user_books
         INNER JOIN books ON user_books.book_id = books.id
         INNER JOIN users ON user_books.user_id = users.id
WHERE
      users.age BETWEEN 7 AND 17
  AND (SELECT count(DISTINCT(books.author)) FROM user_books LEFT JOIN books ON user_books.book_id = books.id WHERE user_books.user_id = users.id) = 1
GROUP BY users.id
HAVING (SELECT count(*) FROM user_books WHERE user_id = UID) = 2
```

Второе задание было выполнено за 4 час 30 минут

- ознакомление с ТЗ - 20 минут
- изучение [spatie/laravel-query-builder](https://packagist.org/packages/spatie/laravel-query-builder) 40 минут
- создание роутов для аутентификации - 1 час 20 минут
- UI для регистрирования - 1 час 10 минут
- тестирование - 35 минут
- написание readme - 25 минут

### Для проверки правильности выполнения заданий
- `composer install` - для установления зависимостей
- `.env.example` скопировать в `.env`
- для тестовой среды необходимо выполнить `docker-compose up -d --build` (поднимаем базу данных) (подождать 30 секунд)
- для создания таблиц нужно выполнить `php artisan migrate`
- для наполнения таблиц `php artisan db:seed`
- для наполнения таблицы `rates` выполняем `php artisan db:seed --class=RateSeeder`
- для поднятие сервера выполняем `php artisan serve`


После всех этих действий на порте 
- `50006` будет доступен `phpMyAdmin` `http://127.0.0.1:50006/` (`login:pass` -> `root:root`)
- `8080` доступен сервис `http://127.0.0.1:8080/`



#####Для проверки первого задания нужно зайти в `phpMyAdmin` и выполнить вышенаписанный запрос.
#####Для проверки второго задания нужно
- зарегистрироваться на сайте `http://127.0.0.1:8080/`
- выполнить `POST` запрос `http://127.0.0.1:8080/api/auth/login?email={email}&password={password}` указав email и пароль. В ответе будет возвращён токен. Пример ответа.
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODA4MFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYyNDAxNTM0NiwiZXhwIjoxNjI0MDE4OTQ2LCJuYmYiOjE2MjQwMTUzNDYsImp0aSI6IkdnQWNvM3J4V3h4aEJmMGUiLCJzdWIiOjM0LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.tQKznJ48PVav2qRD79ZB1bxQDWNAehK7qrbGfSJeBI8",
    "token_type": "bearer",
    "expires_in": 3600
}
```
- получив токен уже можно будет обращаться к другим методам api

```
curl -H 'Accept: application/json' -H "Authorization: Bearer ${TOKEN}" http://127.0.0.1:8080/api/rates
curl -H 'Accept: application/json' -H "Authorization: Bearer ${TOKEN}" 'http://127.0.0.1:8080/api/rates?filter[currency]=USD'
curl -X POST -H 'Accept: application/json' -H "Authorization: Bearer ${TOKEN}" -F 'currency_from=BTC' -F 'currency_to=USD' -F 'value=1' http://127.0.0.1:8080/api/convert
```
