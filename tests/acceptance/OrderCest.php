<?php
use yii\helpers\Url;

class OrderCest
{
    public function _fixtures()
    {   return [
            'Orders' => [
                'class' => \app\tests\fixtures\OrderFixture::class,
                'dataFile' => codecept_data_dir() . 'order.php',
            ],
            'Parts' => [
                'class' => \app\tests\fixtures\PartFixture::class,
                'dataFile' => codecept_data_dir() . 'part.php',
                //'depends' => ['Orders'],
            ],
            'Labor' => [
                'class' => \app\tests\fixtures\LaborFixture::class,
                'dataFile' => codecept_data_dir() . 'labor.php',
            ],
            'Owns' => [
                'class' => \app\tests\fixtures\OwnFixture::class,
                'dataFile' => codecept_data_dir() . 'owns.php',
                //'depends' => ['Parts'],
            ],
            'Customers' => [
                'class' => \app\tests\fixtures\CustomerFixture::class,
                'dataFile' => codecept_data_dir() . 'customer.php',
                //'depends' => ['Owns'],
            ],
            'Automobiles' => [
                'class' => \app\tests\fixtures\AutomobileFixture::class,
                'dataFile' => codecept_data_dir() . 'automobile.php',
                //'depends' => ['Owns'],
            ],
        ];
    }

    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testCreateOrder(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked
        $I->click('#order-button');
        $I->click('#order-create');
        $I->wait(2); // wait for button to be clicked
        $I->click('#add-customer');
        $I->wait(2); // wait for button to be clicked
        $I->fillField('input[name="Customer[first_name]"]', 'Customer');
        $I->fillField('input[name="Customer[last_name]"]', '3');
        $I->fillField('input[name="Customer[phone_number_1]"]', '705-788-8787');
        $I->fillField('input[name="Customer[street_address]"]', 'Hello');
        $I->fillField('input[name="Customer[city]"]', 'New York');
        $I->click('/html/body/div[1]/div/div/div[2]/div/div/div[2]/div/div/div/form/div[7]/span/span[1]/span');
        $I->wait(1);
        $I->click('/html/body/div[1]/div/div/div[2]/span/span/span[2]/ul/li[1]');
        $I->fillField('input[name="Customer[zip]"]', '10001');
        $I->click('#save-customer');
        $I->wait(1); // wait for button to be clicked
        $I->click('#new_automobile');
        $I->wait(1);
        $I->fillField('input[name="AutomobileForm[make]"]', 'Honda');
        $I->fillField('input[name="AutomobileForm[model]"]', 'Civic');
        $I->fillField('input[name="AutomobileForm[year]"]', '2000');
        $I->fillField('input[name="AutomobileForm[vin]"]', '123456789');
        $I->fillField('input[name="AutomobileForm[motor_number]"]', '1.2');
        $I->click('#create-automobile');
        $I->wait(1); // wait for button to be clicked
        $I->fillField('input[name="Order[odometer_reading]"]', '1234');
        $I->click('#save_order');
        $I->wait(1); // wait for button to be clicked
        $I->see("Update Order: Customer 3 - Honda Civic");
        $I->see('Stage: "Created"');
        // add part
        // $I->click('#tabPartsLaborLink');
        // $I->wait(1);
        // $I->click('#new_part_button');
        // $I->wait(1);
        // $I->fillField('input[name="Part[description]"]', 'Breaks');
        // $I->fillField('input[name="Part[part_number]"]', '123');
        // $I->fillField('input[name="Part[price]"]', 100);
        // $I->pause();
        // $I->fillField('input[name="Part[margin]"]', '0');
        // $I->fillField('input[name="Part[quantity]"]', '1');
        // $I->click('/html/body/div[1]/div/div/div[2]/div[3]/div/div/div[2]/div/div/div/form/div[6]/span/span[1]/span/span[1]');
        // $I->wait(0.5);
        // $I->click('/html/body/span/span/span[2]/ul/li[2]');
        // $I->click('#btn-save-part');
    }

    public function testViewOrder(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(1); // wait for button to be clicked
        $I->click('#order-button');

        //check totals
        $I->see('Customer 1');
        $I->see('Honda');
        $I->see('Civic');
        $I->see('2000-01-01 00:00:00');
        $I->see('2000-01-02 00:00:00');
        $I->see('Created');
        $I->see('Paid');
        $I->see('$111');
        $I->see('$100');
        $I->click("//*[@id=\"w0\"]/table/tbody/tr[1]/td[8]/a[1]");
        $I->see("Customer 1 - Honda Civic");
        $I->see('Stage: "Created"');
        $I->see('Customer 1');
        $I->see('Honda Civic 2000');    
    }
}
