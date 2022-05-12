# Work Order Management System

## Setup
Note: This project runs in PHP7. This project has not been tested with PHP8.

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

- To get all the tables that you need in your database, run the following command inside of the project folder: 
    - Production: `$ php7 yii migrate/up 2` (This will initialize the database and rbac)
    - Development/Testing: `$ php7 yii migrate/fresh` (This will initialize the database, rbac, and seeds with testing users).

## Setup Admin User DO THIS IN ORDER TO SECURE YOUR INSTALL
- After logging in as admin (username: admin password: admin), go to Admin Tools.
- Edit the admin user and change the password.

## Run the project

- To run the project, run the command `php7 yii serve` inside of the project folder

## Deploy the project on Apache
The following is an example of how to link the project in your apache server
``` 
<IfModule alias_module>
    #
    # Alias: Maps web paths into filesystem paths and is used to
    # access content that does not live under the DocumentRoot.
    # Example:
    # Alias /webpath /full/filesystem/path
    Alias "/tune" "/srv/http/tuneup"

    # ...
</IfModule>

<Directory "/srv/http/tuneup">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```
Don't forget to turn on rewrite engine module in apache and to give the right permissions to the project folder so that Apache can access it.

## Run Tests
In order to run both unit tests and acceptance tests created for this project, one must follow the following steps
- Install Chromedriver
- Setup the project as provided above
### Unit Tests
- Run the following command `php7 vendor/bin/codecept run unit` inside of the project folder
### Acceptance Tests
- Run the following command `chromedriver --url-base=/wd/hub --port=4444` and keep the process running
- Serve the project using the development command.
- Run the following command to start the tests: `php7 vendor/bin/codecept run acceptance` inside the project folder
