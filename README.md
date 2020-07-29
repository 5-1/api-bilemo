# api-bilemo
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e93aa24a6896431cbcc49f34cf79cb18)](https://www.codacy.com/manual/5-1/api-bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=5-1/api-bilemo&amp;utm_campaign=Badge_Grade)

Welcome to BileMo! on api that uses Symfony 4.4, noted B on codacy.

What's inside?
--------------

This project is linked to Openclassrooms DA PHP Symfony studies.
It's the 7th projets in which it is asked to create an API with users, product (phone) and customer!
it must be possible to:

     consult the list of BileMo products;
     view the details of a BileMo product;
     view the list of registered users linked to a client on the website;
     view the details of a registered user linked to a customer;
     add a new user linked to a customer;
     delete a user added by a customer.
Require
--------------

PHP 7 / MySQL / Apache.
More easy if you download mamp/wamp/XAMP.
Composer for Symfony 4.4

ORM
--------------
Doctrine

# Installation

Clone the repository: 

```
git clone https://github.com/5-1/api-bilemo.git
```

Install dependencies:
```
composer install
```

Create and edit a new env file `.env.local`
```
# .env.local
DATABASE_URL=mysql://your_login:your_password@127.0.0.1:3306/your-databasename
```
Create the database:
```
bin/console doctrine:database:create
```

Load the fixtures with reset script:
```
bin/console composer reset
```



If you have any question, you can contact me with github :)
