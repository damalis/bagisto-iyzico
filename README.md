# [bagisto iyzico](https://github.com/damalis/bagisto-iyzico)

Iyzico payment gateway for [Bagisto Laravel ecommerce](https://bagisto.com/)

<p align="left">
<a href="https://www.iyzico.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/3815564?s=200&v=4" alt="iyzico" width="150px" /> </a>&nbsp;&nbsp;&nbsp;
<a href="https://bagisto.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/43133047?s=200&v=4" alt="bagisto laravel ecommerce" width="150px" /> </a>
</p>

#### With this project you can quickly run the following:

- [iyzico](https://github.com/iyzico/iyzipay-php)
- [Bagisto](https://github.com/bagisto)

### Installation

```
composer require damalis/bagisto-iyzico
```

- Run these commands below to complete the setup

```
composer dump-autoload
```

- iyzico logo file will be copied to the specified location

```
php artisan vendor:publish --tag=iyzico --force
```

```
php artisan optimize:clear
```

### Usage

Go to **Admin >> Configuration >> Sales >> Payment Methods -> Iyzico**

[Test account for payment](https://sandbox-merchant.iyzipay.com/auth/login)

[Test Card Details](https://docs.iyzico.com/en/add-ons/test-cards)


#### if You don't see the "Thank you for your order!" page in your browser after success payment.

add |```SESSION_SAME_SITE=none```| in the .env file

tried with Bagisto Version 2.3.7 product
