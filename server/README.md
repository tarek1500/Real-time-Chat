# Chat-Server
Real-time Chat server based on Laravel.

## Installation
- Use composer dependency manager [Composer](https://getcomposer.org/) to install the Chat server.
```bash
composer install
```
- Copy **.env.example** file to **.env** on the root folder.
- Open your **.env** file and change **database** & **pusher** values, change **Broadcast Driver** to **pusher**.
- Run the following command to generate a key for your project:
```bash
php artisan key:generate
```
- Run the following command for migrations:
```bash
php artisan migrate
```
- Run the following command to create passport encryption keys:
```bash
php artisan passport:install
```

## Usage
Use the following command to start socket listening: (Note that **host** & **port** are optional)
```bash
php artisan websockets:serve --host=[HOST] --port=[PORT]
```

## Voila! We are ready to start.