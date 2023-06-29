# maxDiscountedPrice
-----------------------------

# Before you begins:
the task is done by laravel framework, version 10+
requires php 8.1 and above
requires WAMP / XAMPP / Laragon (recommended, lite weight and ease of use in Windows system)

Do the following steps (Installation & Config):
----------------------------------------------------------------------------------------
1. pull from master branch
2. direct to project folder
3. find file named ".env.example"
4. rename it to ".env"
5. update following lines:
  5.1.  update "DB_DATABASE" with your DB name
  5.2.  update "DB_USERNAME" with your DB username
  5.3.  update "DB_PASSWORD" with your DB password. if no password, keep it blank
  5.4.  update APP_URL if neccessary
6. go to commandline client, install packages via composer. enter "composer i"
7. verify vendor folder is exists
8. create migrations & call seeders "php artisan migrate:fresh --seed"
9. verify in DB by checking tables "discounts,carts,products"
10. verify data on tables: discounts, products
11. goto CLI / Command line client, enter: "php artisan serve"
12. you will get a link to checkit in your localhost, check application through that link

# Application working
-----------------------------------------------------------------------------------------------------------------
