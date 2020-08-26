## Simple group blog

This blog was developed as test for job interview and for my own personal learning experience. This blog includes very simple features and has minimal design. To run it on your server you need some tools, such as:

The demo is located at https://laravel-blog.actionthrive.com/

## Requirements

- PHP 5.6+
- NPM package manager
- Composer package manager
- Mysql

## Features

- Posts with video, image and rich text
- Categories which should be edited with direct Mysql queries
- Tags
- Search
- Pagination
- Recent posts
- Comments
- Bootstrap user scaffolding (auth, registration, password recovery)
- Simple user managment (delete & edit)

If you feel like forking it, go ahead!

## How to install via SSH

- Clone repo to your server - git clone https://github.com/romettm/laravel-blog.git
- Get PHP libraries: composer install
- Get JS libraries: npm install
- Generate .env file and fill your database credentials
- Import database by running: php artisan migrate
- Generate key for laravel: php artisan key:generate 


