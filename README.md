## Exercise CRUD API

https://github.com/jphilip666/Exercise_CRUD_API

This project is a Laravel project. It has a Web application with CRUD operation on Suppliers and Supplier Rates.
It also has Restful API implemented using Laravel Sanctum Authentication package. It also has Login/Register webpages which was created by the package Laravel Breeze. Once you login then you will see the Supplier and Supplier rates CRUD operations which was implemented by me.

## Installation instruction

# Exercise_CRUD_API
- Download this project from the repository and CD into the root directory.
- There will be a .env file which you will need to use to enter the database credentials. 
    - Please enter DB_CONNECTION=mariadb or mysql and then enter the database credentials
- Once you have configured the database connection, from the root directory enter the following command to generate database tables and data
    - php artisan migrate —seed
    - The above command will also create a test user which you can use to login and also some test data from the Word documentation.
- Please use the following user email/password to login if you don’t want to register
    - Email: jestin.philip@icloud.com
    - Password: letmein
- Then run the following command to start the PHP application
    - php artisan serve
    - Then you can access the Application usually at http://127.0.0.1:8000
    - You will need this running if you want to test the API

# Postman

To test the API I created some postman requests to make it easier to test it. You can use the link below and then import it in your Postman. You will need the CRUD application running to test it. We will be using http://127.0.0.1:8000 to test the API’s.

https://api.postman.com/collections/11954745-d8f83280-c130-4164-a304-7f74a624ca80?access_key=PMAT-01J18WB6VMW0H2568P9TXRS1TH