# p6-snowtricks

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/978b0925ef414314812950e1e2a3cc6c)](https://app.codacy.com/gh/erwan-h-dev/p6-snowtricks/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

## DESCRIPTION

Snowtricks est un annuaire communautaire de partage de figures de snowboard.
Celui-ci permet aux utilisateurs de visualiser et commenter des figures existantes, 
ainsi que de créer, modifier et de les supprimer des figures.

Le projet a été développer dans un contexte pédagogique pour OpenClassrooms.
 [DEMO](http://p6-snowtrick.erwan-h.fr:48200/)

## REQUIREMENTS
* PHP 8.*
* MySQL 8.*
* Node 18.14.*
* Composer 2.5.*

## INSTALLATION

1. Clone the repository
```bash
git clone
```

2. Install dependencies
```bash
composer install
npm install
```

3. Create database
```bash
php bin/console doctrine:database:create
```

4. Create database schema
```bash
php bin/console doctrine:schema:create
```

5. Load fixtures
```bash
php bin/console doctrine:fixtures:load
```

6. Build assets
```bash
npm run build
```

- The default admin account is : 
    * username : admin
    * password : password 