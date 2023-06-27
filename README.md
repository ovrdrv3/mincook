# mincook
minimum cook project - crowdsourced recipe site

# Local deploy settings
- touch .env and bring in db credentials
- create db with name from .env in SQL
- composer install
- php artisan key:generate
- php artisan migrate
- nvm install 9
- npm install --legacy-peer-deps
- npm run dev
- php artisan serve

# Getting photos saved using symlink
- php artisan storage:link

# adding some fake data

- php artisan tinker
- factory(App\Recipe::class, 10)->create();
