#GroupUp API

##Installation

###Requirements

- Install Git if necessary.

- Install PHP 7.0 and required extensions:

```
sudo apt-get install php7.0
sudo apt-get install php7.0-zip
sudo apt-get install php7.0-mbstring
sudo apt-get install php7.0-dom 
```

- Install [Composer](https://getcomposer.org/).

###Get started

- Clone repository where you want it to be:

```
git clone https://github.com/Strift/GroupUp-API.git
```

- Get inside the folder and install dependencies:

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

To set up the database, run the migrations:

```
php artisan migrate
```

If you want the seeding to be done (store some default data after runnning the migrations):

```
php artisan db:seed
```

To refresh (rollback and re-run all migrations) and seed:

```
php artisan migrate:refresh --seed
```