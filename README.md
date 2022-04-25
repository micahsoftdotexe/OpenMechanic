# Work Order Management System

## Setup

### First Steps

- Clone the repository
- Configure settings in `.config` folder:
    - create and modify the `db-local.php` file to point to your database (I recommend using XAMPP or something similar for your database)
        - You can add the following code and modify it as needed 
            ``` php
            <?php
            return [
            'charset' => 'utf8',
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=workorder',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            ];
            ```
- Install composer (https://getcomposer.org/)
- Open a terminal inside the project folder and run `$ composer install` If that returns an error try `$ composer update`

### Migrate Database

- To get all the tables that you need in your database, run command: 
    - Production: `$ php7 yii migrate/up 2` (This will initialize the database and rbac)
    - Development/Testing: `$ php7 yii migrate/fresh` (This will initialize the database, rbac, and seeds with testing users).

## Setup Admin User DO THIS IN ORDER TO SECURE YOUR INSTALL
- After logged in as admin (username: admin password: admin), go to Admin Tools.
- Edit the admin user and change the password.

## Run the project

- To run the project, run the command `php7 yii serve`

