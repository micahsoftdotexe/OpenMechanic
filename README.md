# Work Order Management System

## Setup

### First Steps

- Clone the repository
- Configure settings in `.config` folder:
    - modify the `db-local.php` to point to your database (I recommend using XAMPP or something similar for your database)
- Install composer (https://getcomposer.org/)
- Open a terminal inside the project folder and run `$ composer install` If that returns an error try `$ composer update`

### Migrate Database

- To get all the tables that you need in your database, run command: `$ php yii migrate`

## Run the project

- To run the project, run the command `php yii serve`
