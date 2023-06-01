# p6-snowtricks

## DESCRIPTION

Snowtricks est un annuaire communautaire de partage de figures de snowboard.
Celui-ci permet aux utilisateurs de visualiser et commenter des figures existantes, 
ainsi que de créer, modifier et de les supprimer des figures.

Le projet a été développer dans un contexte pédagogique pour OpenClassrooms.
 [DEMO](http://p6-snowtrick.erwan-h.fr:48200/)
## INSTALLATION

0. use php 8.* and mysql 8.*

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