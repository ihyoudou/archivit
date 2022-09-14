# Archivit

Application to archive subreddits from Reddit with web interface written using Laravel. Highly work in progress.


## Goal

* Archive subreddits with media
* Archive comments on posts
* Archive user profiles
* Support local and remote media store (e.g. S3 object storage)
* Usable web interface and admin interface

## What is working?

* Archiving last 100 posts on subreddits

## Requirements

* PHP 8+
* MySQL/MariaDB Database (but PostgreSQL should also work)
* Composer
* Crontab

## How to install
WIP

### How to setup cronjob
WIP


## Setup development environment
If you have Docker installed, you can utilize Laravel Sail to quickly boot-up development environment
```
git clone https://github.com/ihyoudou/archivit
cd archivit
composer update
cp .env.example .env
php artisan key:generate
./vendor/bin/sail up
```

