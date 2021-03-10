<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Дипломный проект по ВКР
### "Разработка образовательного портала по школьному курсу физики, используя фреймворк Laravel"
студентки 4 курса<br>
Конюховой Антонины Евгеньевны<br>
направления подготовки "Прикладная математика и информатика"



### Инструкция по настройке пользователя БД (Laragon on Windows):
1. Задать мастер-пароль, например password.
2. Создать БД fizika2020.
3. Находясь в папке проекта войти в БД под пользователем root:
```code
mysql -u root -p fizika2020
```
4. Войдя в >mysql создать пользователя oto2020 и задать ему пароль:
```code
CREATE USER 'oto2020' IDENTIFIED BY 'password';
```
5. Дадим пользователю 'oto2020' все привелегии по работае с таблицами БД fizika 2020:
```code
GRANT ALL PRIVILEGES ON fizika2020.* TO 'oto2020';
```
6. Выход из >mysql:
```code
exit
```
### Инструкция по подключению Laravel к БД:
1. В корне проекта из <b>.env.example</b> копируем и переименовываем в <b>.env</b>
2. В <b>.env</b> в ~12-15 строках задаём БД, пароль и имя пользователя, которые Laravel будет использовать для подключения к БД:
```code   
DB_DATABASE=fizika2020
DB_USERNAME=oto2020
DB_PASSWORD=password
```
### Инструкция по авто-формированию структуры таблиц и авто-заполнению оных содержимым (миграции):
1. Для начала работы не будет лишним сгенерировать секретный ключ приложения:
```code   
php artisan key:generate
```
2. Создадим структуру таблиц из /database/migrations: 
```code   
php artisan migrate
```
3. Заполним таблицы содержимым из /database/seeds:
```code   
php artisan db:seed
```

## Рабочий сайт доступен по адресу: [phys.ml](http://phys.ml)

