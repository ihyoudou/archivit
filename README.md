# Archivit

Application to archive subreddits from Reddit with web interface written using Laravel. ~~Highly work in progress.~~

In a retrospect i'm not really happy with this design where the app parse Reddit JSON output and create database records, it is pretty slow with many comments and resource heavy. Idea for v2 is to keep versioned JSON and just parse it on user visit (instead of making recurring one-to-one relations).

## Goal

- [x] Archive subreddits   
- [ ] Archive posts with images (partial)  
- [ ] Archive posts with video  (partial)
- [x] Archive comments on posts  
- [ ] Archive user profiles  
- [ ] Support local and remote media store (e.g. S3 object storage)  
- [ ] Usable web interface and admin interface

### Current state
- Archive posts with images  
Works with direct image links (and compressing them to webp), Imgur albums are not yet working
- Archive posts with video  
Works with reddit video (todo: add compressing), Streamable, gfycat etc services support planned in future
- Support local and remote media store (e.g. S3 object storage)  
As media downloaders use Laravel `storage` function, it should work, but it needs testing
- Usable web interface and admin interface  
Admin panel exist - there are basic stats and add/remove subreddit options, more to come.

## Requirements

* PHP 8.1+
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

