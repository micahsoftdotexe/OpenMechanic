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
        'username' => 'micaht',
        'password' => 'conn123',
        'charset' => 'utf8',
        ];
        ```
];
- Install composer (https://getcomposer.org/)
- Open a terminal inside the project folder and run `$ composer install` If that returns an error try `$ composer update`

### Migrate Database

- To get all the tables that you need in your database, run command: `$ php yii migrate`

## Run the project

- To run the project, run the command `php yii serve`
