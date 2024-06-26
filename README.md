# Exercise CRUD API

This project is a Laravel project. It has a Web application with CRUD operation on Suppliers and Supplier Rates.
It also has Restful API implemented using Laravel Sanctum Authentication package. It also has Login/Register webpages which was created by the package Laravel Breeze. Once you login then you will see the Supplier and Supplier rates CRUD operations which was implemented by me.

## Installation instruction

- Download this project from the repository and CD into the root directory.
- There will be a .env file which you will need to use to enter the database credentials. 
    - Please enter DB_CONNECTION=mariadb or mysql and then enter the database credentials
- Once you have configured the database connection, from the root directory enter the following command to generate database tables and data
    - php artisan migrate —seed
    - The above command will also create a test user which you can use to login and also some test data from the Word documentation.
- Then run the following command to start the PHP application
    - php artisan serve
    - Then you can access the Application.
    - You will need this running if you want to test the API

## PHPUnit tests
- If you want to run the couple of PHP feature tests I implemented for the API the use the command below inside the root directory
    - php artisan test --filter APITest
