# Loov Solutions PHP Sdk

<p align="center">
  <a href="https://packagist.org/packages/loov/php-sdk">
    <img src="https://img.shields.io/packagist/dt/loov/php-sdk" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/loov/php-sdk">
    <img src="https://img.shields.io/packagist/v/loov/php-sdk" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/loov/php-sdk">
    <img src="https://img.shields.io/packagist/l/loov/php-sdk" alt="License">
  </a>
</p>

## Introduction

Loov Solutions is an online payment tools....

## Installation

Run this in your terminal to install Shopper from command line:

``` bash
composer require loov/php-sdk
```
## Requirement

<table>
    <tr>
        <th>Varibale name</th>
        <th>Type</th>
        <th>Required</th>
    </tr>
    <tr>
        <td>amount</td>
        <td>number</td>
        <td>yes</td>
    </tr>
     <tr>
        <td>sender_currency</td>
        <td>string</td>
        <td>yes</td>
    </tr>
    <tr>
       <td>return_url</td>
       <td>string</td>
       <td>yes</td>
    </tr>
    <tr>
       <td>notify_url</td>
       <td>string</td>
       <td>no</td>
    </tr>
    <tr>
       <td>cancel_url</td>
       <td>string</td>
       <td>yes</td>
    </tr>
    <tr>
       <td>APP-KEY</td>
       <td>string</td>
       <td>yes</td>
    </tr>
    <tr>
       <td>MERCHANT-KEY</td>
       <td>string</td>
       <td>yes</td>
    </tr>
</table>

## Make a payment
```
<?php
namespace App\Http\Controllers;
use Loov\PhpSdk\LoovPay;

class payment extends Controller
{
    public function index()
    {

         $data = [
            'amount' => 2000,
            'sender_currency' => 'XAF',
            'return_url' => 'https://cosna-afrique.com',
            'cancel_url' => 'https://cosna-afrique.com',
            'notify_url' => 'https://cosna-afrique.com',
        ];

        $res = (new LoovPay())->setKeys('de2319fa-4fdf-4b00-b978-e9c9d9347f0b', 'e8fc3198-af18-478a-8c20-e8735e0e1021')->initPayment($data);
        return [$res];
    }
}

```

## Check transaction status
```
<?php
namespace App\Http\Controllers;
use Loov\PhpSdk\LoovPay;

class payment extends Controller
{
    public function testPayment()
    {
         $this->objet()->checkStatus('loov-4OWDBDjcbV');
    }
}


```

## License

The Loov Solutions PHP SDK is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Security

If you discover any security related issues, please email randyahmedjunior@gmail.com instead of using the issue tracker.

It's _heavily_ recommended that you **[subscribe to the Loov Newsletter](http://loov-solutions.com)** so you can find out about any security updates, breaking changes or major features.
We send an email about 3-4 emails per year. Sometimes less.
