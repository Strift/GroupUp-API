#GroupUp API

##Installation

###Requirements

The installation processed below is detailed for Ubuntu 16.04 LTS, but it should be quite similar on any Unix-based OS. The only difference should be the package manager that you use.

- Install Git.

```
sudo apt-get install git
```

- Install PHP 7.0 and required extensions (you may require to add the Personal Package Archive first).

```
sudo add-apt-repository ppa:ondrej/php # PHP package repository
sudo apt-get update # If you added the repository
sudo apt-get install php7.0
sudo apt-get install php7.0-zip
sudo apt-get install php7.0-mbstring
sudo apt-get install php7.0-dom
sudo apt-get install php7.0-curl
sudo apt-get install php7.0-mysql
```

- Install MySQL. Leave the default settings and press Enter when needed.

```
sudo apt-get mysql-server
```

- Install [Composer](https://getcomposer.org/).

```
curl -sS https://getcomposer.org/installer | php
```

- (Optional) Add Composer to your path.

```
chmod a+x composer.phar
sudo mv composer.phar /usr/local/bin/composer
```

###Get started

- Clone this repository.

```
git clone https://github.com/Strift/GroupUp-API.git
```

- Get inside the folder and install dependencies.

```
cd GroupUp-API
composer install
```

- Set up environment: copy '.env.example' as '.env', edit properties if needed

- Generate Application Key

```
php artisan key:generate
```

###Setting up database

To set up or reset the database, run the migrations.

```
php artisan migrate:refresh --seed
```
