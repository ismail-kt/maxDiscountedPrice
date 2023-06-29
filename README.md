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
1.  Product List is populating from DB
2.  Click add to cart button to add a product to cart,
3.  in case of adding same product again to cart, cart product count is updates
4.  on adding a product to cart, you may change quantity of the product or keep it default
5.  cart is getting updated on right side
6.  in cart, Clear cart is to remove all cart items
7.  [ X ] button is used to remove that particular row from cart
8.   [- ] button is for deducting cart product count (particular)
a product count deduction from quantity 1 nos will result in removal of the certain product from cart (cart with zero quantity is not valid)
9.  for all changes made to cart will display "Original Price" and "Total To Pay (after discount)" on time

## Thanks for your time and wonderful opportunity.
