## Hamrodepot.com website

Hamrodepot.com build using latest Laravel and bootstrap 4.

## Packages Used

-   Managing Shopping cart [bumbummen99/shoppingcart]
-   Generate Slug [cviebrock/eloquent-sluggable]
-   Payment Gateway [stripe with cashier]
-   Role Permission [spatie/laravel-permission]

## Environment

.env.example is copy of .env which we used while development.

To run project, we required below value set in .env file

-   APP & Database Setting
-   Stripe Keys
-   SMTP
-   Product Limit [We used value "12" during development]
-   Other Setting you can leave as default or can change based on your need

## Hosting

Poject is hosted on Amazon Web Service and domain is managed on GoDaddy

-   EC2 with Apache and PHP
-   RDS for managing database

You can find private key for connecting EC2 instance in S3 bucket on AWS. You may need to allow your IP to connect with EC2 in security policy
