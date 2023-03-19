<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Challenge Latina.pe - create api user


- versión utilizada de PHP: 8.1
- Laravel 10
- Crear la BD llamada "bd_user" en MySQL con el siguiente comando: create database bd_user
- configurar el .env con las credenciales de su BD
- Las credenciales de AWS para la conexión al bucket están en el contenido de correo

Ejecutar los siguientes comandos en la raíz del proyecto:

- composer install
- php artisan migrate
- php artisan serve

Endpoints:
- http://127.0.0.1:8000/api/register

JSON - request:
```
{
        "name": "danilo andres",
        "last_name": "carrion lava",
        "email": "andrescarrion199603@gmail.com",
        "password": "prueba123",
        "birthdate": "1996/03/03"
}
```
JSON - response:
```
{
    "message": "Usuario registrado exitosamente",
    "user": {
        "name": "danilo andres",
        "last_name": "carrion lava",
        "email": "andrescarrion199603@gmail.com",
        "birthdate": "1996/03/03",
        "updated_at": "2023-03-19T04:51:49.000000Z",
        "created_at": "2023-03-19T04:51:49.000000Z",
        "id": 42
}
```
- http://127.0.0.1:8000/api/login

JSON - request:
```
{
     "email":"andrescarrion199603@gmail.com",
     "password": "9w8ZJhVF0f"
}
```
JSON - response:
```
{
    "access_token": "4|wQuIQIGQggTgY6nkQajUpfXZLtcIFTz5h2kGsTVY"
}
```

- http://127.0.0.1:8000/api/reset-password

JSON - request:
```
{
    "email":"andrescarrion199603@gmail.com"
}
```
JSON - response:
```
{
    "message": "Se ha enviado un correo con la nueva contraseña"
}
```
