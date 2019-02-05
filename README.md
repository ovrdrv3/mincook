# mincook
minimum cook project - crowdsourced recipe site

# Local deploy settings
- touch .env and bring in db credentials
- create db with name from .env in SQL
- composer install
- php artisan key:generate
- php artisan migrate
- npm install
- npm run dev

# Getting photos saved using symlink
- php artisan storage:link

# adding some fake data -

- php artisan tinker
- factory(App\Recipe::class, 10)->create();
