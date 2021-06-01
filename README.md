

## Project setup
```shell
composer install
```

## Run
```shell
php artisan migrate
php artisan db:seed
```

```shell
php artisan serve
```

### User Index

```shell
curl http://127.0.0.1:8000/api/v1/users/index 
```

### Create User
```shell
curl -d "name=Boo&email=aikangtongxue@gmail.com&password=122410" http://127.0.0.1:8000/api/v1/users/create
```

### Update User 
```shell
curl -d "id=1&name=Yumi&password=122410" http://127.0.0.1:8000/api/v1/users/update
```