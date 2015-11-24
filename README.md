# vaibhavpandeyvpz/frameworx
Skeleton application on top of [Slim](https://github.com/slimphp/Slim) framework implementing asset management via [Gulp](https://github.com/gulpjs/gulp) & [Bower](https://github.com/bower/bower), [Twig](https://github.com/twigphp/Twig) templates, response [Bootstrap](https://github.com/twbs/bootstrap) front-end, database access via [Doctrine](https://github.com/doctrine/dbal), [Symfony](https://github.com/symfony/symfony) translations and more.

Getting Started
------
- Install [Node.js](https://nodejs.org/en/) on your machine.
- Install [Bower](http://bower.io/) and [Gulp](http://gulpjs.com/) globally using below commands:
```bash
npm i -g bower gulp
```
- Install [Composer](https://getcomposer.org/) using below command:
```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=bin --filename=composer
```
- Install [Frameworx](https://github.com/vaibhavpandeyvpz/frameworx) via composer:
```bash
php bin/composer create-project vaibhavpandeyvpz/frameworx app "@dev"
```
- Move ```config.php.sample``` to ```config.php```, and change **cookies.secret_key**, **security.session**, **session.cookie** to some random values. Those can generated with [this](www.vaibhavpandey.com/etoolkit/#/passwords-generator) tool for ease.
- If you use [Apache HTTPd](https://httpd.apache.org/) server for development, you can move ```vhost.conf.sample``` to ```vhost.conf``` and replace occurences of **${APP_PATH}** to absolute path of your local frameworx ```www``` folder.
- Do not forget to add ```vhost.conf``` to your ```httpd.conf``` as follows:
```conf
Include "/home/<USER>/Sites/frameworx/vhost.conf"
```

License
------
See [LICENSE.md](https://github.com/vaibhavpandeyvpz/frameworx/blob/2.x/LICENSE.md) file.
