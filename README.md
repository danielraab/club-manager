# club manager

## install repo

-   clone repo
-   install dependencies:

    - composer
        ```bash
        docker run --rm \
            -u "$(id -u):$(id -g)" \
            -v "$(pwd):/var/www/html" \
            -w /var/www/html \
            laravelsail/php82-composer:latest \
            composer install --ignore-platform-reqs
        ```

* copy `.env.example` to `.env`

* start docker stack: `./vendor/bin/sail up`

*   execute `./vendor/bin/sail artisan key:generate` or via button on the first error page

- create database: `./vendor/bin/sail artisan migrate:fresh`
    - add `--seed` if test data should be installed.

* create vapid keys for webpush: `./vendor/bin/sail artisan webpush:vapid`

* install cron job like in deployment section or
  * execute specific tasks `./vendor/bin/sail artisan schedule:test` 

-   install node/npm packages: `./vendor/bin/sail npm install`

-   start node server for assets:  `./vendor/bin/sail npm run dev`


## sail commands

-   use `./vendor/bin/sail` to list all commands

-   user `./vendor/bin/sail artisan key:generate` to create the app key

-   user `./vendor/bin/sail artisan migrate:fresh --seed` to seed a database

-   `./vendor/bin/sail npm run dev` to start vite

## others

-   if some files are generated via composer or an php command execute:
    -   --> `sudo chown $USER:www-data -R src`
    -   and maybe: `sudo chmod g+w -R ./src`

## tests

### pint

* show result of pint without changes: `vendor/bin/sail pint --test -vvv `
* pint with autocorrect: `vendor/bin/sail pint`

## deploy

Prerequisites:

* local ssh key in `authorized_keys` file on host (remote)
* host (remote) ssh key in gitlab
* proper configured `deploy.php` file

Steps to deploy:

* install all dependencies (composer, npm)
    * `docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$(pwd):/var/www/html" \
      -w /var/www/html \
      laravelsail/php82-composer:latest \
      composer install --ignore-platform-reqs`
    * `./vendor/bin/sail npm install`
* create assets: `./vendor/bin/sail npm run build`
* add build assets to git (incl commit and pull)
    * `git add ./public/build`
    * `git commit -m "add assests"`
    * `git push`
* deploy `./vendor/bin/dep deploy` or `./vendor/bin/sail bin dep deploy`

* enable cron tasks
  * add the following line to your crontab `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
  * change the path to the project path
