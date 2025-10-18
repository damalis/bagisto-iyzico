# [bagisto iyzico](https://github.com/damalis/bagisto-iyzico)

Iyzico payment gateway for [Bagisto Laravel ecommerce](https://bagisto.com/)

<p align="left">
<a href="https://www.iyzico.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/3815564?s=200&v=4" alt="iyzico" width="150px" /> </a>&nbsp;&nbsp;&nbsp;
<a href="https://bagisto.com/" target="_blank" rel="noreferrer"> <img src="https://avatars.githubusercontent.com/u/43133047?s=200&v=4" alt="bagisto laravel ecommerce" width="150px" /> </a>
</p>

#### Key Benefits

- **Easy Configuration:** User-friendly admin interface with clear options
- **Clear Communication:** Progress indicators and security messaging
- **Fast Loading:** Optimized performance for quick payments
- **Consistent Branding:** Seamless integration with your store design

#### Features

- **Secure API Integration:** Direct integration with Iyzico Refund and Cancel API
> [!IMPORTANT]
> It is strictly not recommended to use the Refund service for orders with more than one product in the basket.
- **Partial & Full Refunds:** Support for both partial and complete refund amounts
- **Order Cancel:** Cancel are not supporting partial amounts.
- > [!IMPORTANT]
- > Cancel can be processed on the same day as the payment and does not create any input/output entries on the card statement.
- **Real-time Status Updates:** Instant updates after refund and cancel processing
- **Refund and Cancel History Tracking:** Complete audit trail of all refund and cancel transactions
- **Payment Method Icon:** Upload a custom icon for the payment methods selection page (recommended: 100x50px)

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
php artisan optimize
```

### Usage

Go to **Admin >> Configuration >> Sales >> Payment Methods -> Iyzico**

[Test account for payment](https://sandbox-merchant.iyzipay.com/auth/login)

[Test Card Details](https://docs.iyzico.com/en/add-ons/test-cards)


#### if You don't see the "Thank you for your order!" page in your browser after success payment.

add |```SESSION_SAME_SITE=none```| in the .env file and run ```php artisan config:cache```.

tested with Bagisto Version 2.3.7 product
