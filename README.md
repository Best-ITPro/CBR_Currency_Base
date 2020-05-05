Подробная информация по данному проекту описана в в файле cbr.currency.txt в корне проекта, а так же на на сайте 

http://best-itpro.ru 


## XML Parser CBR Currency Base - Официальные курсы валют на заданную дату, устанавливаемые ежедневно

Получение данных о ежедневных курсах валют ЦБ РФ, используя официальный XML http://www.cbr.ru/development/SXML/


Исходный код проекта: https://github.com/Best-ITPro/CBR_Currency_Base

## Установка XML Parser CBR Currency Base


Создаем папку проекта и разворачиваем там архив с исходным кодом. 

Подразумевается, что настройку веб-сервера Вы производите самостоятельно, настройте сервер и, при помощи phpmyadmin или другого ПО создайте базу данных для проекта. Информация по подключению к базе данных будет указана ниже в файле .env

Переходим в папку проеката и запускаем команды:

1). Запускаем команду: composer install

2). Запускаем команду: npm install

3). Копируем фал .env.example в .env и редактируем файл .env:

APP_NAME=CBR.Currency.Base (или любое другое имя проекта)

APP_URL=http://ВашДомен

APP_DEBUG=true (если Вам нужно поработать с отладчиком Laravel Debug)
или

APP_DEBUG=false (на продакшн)


DB_HOST=localhost

DB_DATABASE=cbr.currency

DB_USERNAME=ВашЛогинКБазе

DB_PASSWORD=ВашПарольКБазе

Можно настроить smtp (на примере Яндекс):

MAIL_DRIVER=smtp

MAIL_HOST=smtp.yandex.ru

MAIL_PORT=587

MAIL_USERNAME=ВАШ_ЛОГИН

MAIL_PASSWORD=ВАШ_ПАРОЛЬ

MAIL_ENCRYPTION=tls

MAIL_FROM_ADDRESS=ВАШ_EMAIL

MAIL_FROM_NAME="${APP_NAME}"

4). Запускаем миграции: php artisan migrate

5). Генерируем ключ php artisan key:generate

6). Очищаем кеш php artisan config:cache

7). Меняем права доступа к системным папкам и делаем ссылку на папку загрузки файлов:

sudo chown www-data:www-data bootstrap/cache

sudo chmod -R 777 bootstrap/cache/*

sudo chown www-data:www-data storage/*

sudo chmod -R 777 storage/*

sudo chown www-data:www-data /storage/logs/laravel.log

sudo chmod -R 777 storage/logs/laravel.log

8). Делаем ссылку на папку загрузки файлов (на перспективу): 
sudo php artisan storage:link

9). Для установки Yarn в папке проекта надо запустить команды: 

npm i yarn -g

потом: yarn

10). Запускаем сборку фронтенда командой: npm run dev

11). Подразумевается, что настройку веб-сервера Вы производите самостоятельно, при настройке сайта указывайте коренную папку сайта следующим образом: папка_сайта/public/

12). Заходим через браузер на сайт собранного проекта: http://АдресПроектаВВашейСети

13). При успешной загрузке стартовой страницы нужно сделать первоначальню загрузку данных с сайта ЦБ РФ: 

14). Делаем первоначальную загрузку перечня валют - красная кнопка - "Проверить обновление перечня" - загружаются данные, потом кнопка "Назад"

15). Делаем первоначальную загрузку курсов валют - зеленая кнопка - "Проверить обновления курсов" - загружаются данные, потом кнопка "Назад"

16). Добавляем в крон задание:

пять звездочек cd /ПапкаСайтаНаВашемСервере/ && php artisan schedule:run >> /dev/null 2>&1

17). Наслаждаемся программой. 

Обновления проверяются дважды в день - в 12 и в 15 часов.

Различные управляющие константы заданы в модели Currency. Одной из таких констант является глубина загружаемой базы курсов, это DATE_FROM = "01/06/2019". 
Так как первоначальная загрузка может занять продолжительное время, рекомендуем перед ее запуском установить в Вашем php.ini параметр max_execution_time = 300. 
После загрузки можно вернуть его назад max_execution_time = 30. 
Если в процессе первоначальной загрузки Вы не сделали этого, и произошла ошибка, очистите таблицу currency_dates и запустите процесс загрузки заново.


Демонстрацию проекта можно увидеть по ссылке:  http://courses.best-itpro.ru

Исходный код проекта доступен по ссылке: https://github.com/Best-ITPro/CBR_Currency_Base

Пример простого скрипта парсинга курсов валют под 1С-Битрикс: http://best-itpro.ru/cbr/


;)




<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
