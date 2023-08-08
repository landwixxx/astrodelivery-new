#!/bin/sh
cp .env.example .env
php artisan optimize
php artisan key:generate