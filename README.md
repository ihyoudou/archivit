# Archivit

Application to archive subreddits from Reddit with web interface written using Laravel. Highly work in progress.


## Goal

- [x] Archive subreddits   
- [ ] Archive posts with images (partial)  
- [ ] Archive posts with video  (partial)
- [ ] Archive comments on posts  
- [ ] Archive user profiles  
- [ ] Support local and remote media store (e.g. S3 object storage)  
- [ ] Usable web interface and admin interface

## Requirements

* PHP 8+
* MySQL/MariaDB Database (but PostgreSQL should also work)
* Composer
* Crontab

## How to install
WIP
```
cp .env.example .env
php artisan key:generate
php artisan storage:link
```
Change database credentials in `.env` and set `APP_NAME`, `APP_URL`, `APP_MEDIA_URL`

### How to setup cronjob
WIP

### Create web administrator account
```
php artisan archivit:createadmin
```

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

