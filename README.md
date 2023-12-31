# [bagisto iyzico](https://github.com/damalis/bagisto-iyzico)

Iyzico payment gateway for [Bagisto Laravel ecommerce](https://bagisto.com/)

<p align="left"> <a href="https://www.iyzico.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/3815564?s=200&v=4" alt="iyzico" height="40" width="40"/> </a>&nbsp;&nbsp;&nbsp; <a href="https://bagisto.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/43133047?s=200&v=4" alt="bagisto laravel ecommerce" width="40" height="40" width="40"/> </a>

#### With this project you can quickly run the following:

- [iyzico](https://github.com/iyzico/iyzipay-php)
- [Bagisto](https://github.com/bagisto)

## Installation

```
composer require damalis/bagisto-iyzico
```

then

add below code in the ./config/app.php file

```
'providers' => [
	// Iyzico provider
	Damalis\Iyzico\Providers\IyzicoServiceProvider::class,
]
```

and

```
php artisan config:cache
```

## Usage

Go to Admin -> Configuration -> Sales -> Payment Methods -> Iyzico

[Test account for payment](https://sandbox-merchant.iyzipay.com/auth/login)