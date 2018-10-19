# Laravel Email-Verifiable Package

Similarly to registration verification by email built in Laravel 5.7, this package utilizes some of the built-in functionality to add similar capability to other models, primarily those created via form submission by guest users and/or signed-out users.

## Sample Use Case
 
### Sign up for membership without having to deal with an account 

Some users may feel cumbersome to have to do the account, especially when the organization provide no service that would require members to log into their account.  

### Renew membership without having to log in

Similarly, members may be motivated enough to renew their membership, but would have no use of an online membership account otherwise.  

### Make a donation without having to log in
 
(_No detail at this time_)


## Dependencies

- good-system/theme

This package provides a set of layouts and styles.  If custom theme or views are desired,  this is not desired, create a set of custom views under `/resources/views/vendor/good-system`, and they will each override the counterpart in `good-system/theme`.  

## Installation

This package is less likely to be installed directly, and more likely to be installed as a dependency of other packages.  

Before installation, first add to `composer.json`

```
"repositories": [
    ...
    {
        "type": "git",
        "url": "git@github.com:good-system/laravel-email-verifiable.git"
    }
    ...
]
```

(this may change in the future -- to using a composer package instead of using git as source)

Then 

`composer require good-system/laravel-email-verifiable:"*"`

## Configuration

To make changes to configuration, first publish the config file, then make change in there.

`php artisan vendor:publish --provider="GoodSystem\EmailVerifiable\EmailVerifiableServiceProvider" --tag="config"`

Two configurations allowed for now.

### Routes prefix

This package provides the following routes for verifying and resending signed URLs:

`/email-verifiable/verify/{model}/{id}` 
`/email-verifiable/resend/{model}/{id}`

By default, there's no prefix for the routes.  Custom prefix `routeBase` in `config/email-verification.php` is recognized.

### Middleware 

Add a new middleware group to `Http/Kernel.php`

```
protected $middlewareGroups = [
    'web' => [...],
    'api' => [...],

    'email-verifiable.verified' => [
    
    ]
];
```

Then you can put any middleware you want in this array, and custom logic will be associated with route `/email-verifiable/verify/{model}/{id}`.
```
'email-verifiable.verified' => [
    YOUR-MIDDLE-WARE-CLASS-1,
    YOUR-MIDDLE-WARE-CLASS-1    
]
```  

### Default expiration time for verification URL 

Specify in `default-expiration` by number of minutes.

## Make a model verifiable

Being `email-verifiable` means that a model has an indicator of whether any record of that model has been verified via email after initially created.  This is implemented by adding an one to one polymorphic relationship to the model.

While this package does not dictate how this indicator is used, the motivation for adding such capability is as described in the use cases as following.

### How to make a model verifiable 

After installation and configuration, add trait `CanEmailVerify` to model to make it `email-verifiable`, like so:

```
<?php

namespace GoodSystem\Membership;

use GoodSystem\EmailVerifiable\CanEmailVerify;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use CanEmailVerify;

}
```

This will add the relationship `verifiable`, as well as an attribute `isVerified` that is associated with field `verified_at` in `verifiable` model (provided in this package). 

## UseEmailVerify

Add trait `UseEmailVerify` to controller or any other class, so that the following methods are added:

- `verify(Model $model)`
- `getSignedUrl($modelType, $modelId, array $extra = [], $expiration = null)`

**TODO explain what $extra is for and how to use it**