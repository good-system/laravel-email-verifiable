# Development Documentation


## Defining `email-verifiable`

Being `email-verifiable` means that a model has an indicator of whether any record of that model has been verified via email after initially created.

While this package does not dictate how this indicator is used, the motivation for adding such capability is as described in the use cases as following.
 
## Sample Use Cases

- A user might want to join or renew a membership without having to explicitly register or log into an account
- A user might want to make a donation without having to explicitly register or log into an account
- An organization might want to engage the public in a way more than simply collecting textual feedback, but without putting the users through account registration/login

And in all these cases, email verification could serve as an effective tool for reducing spam (false/invalid/undesired submissions), while providing such convenience. 

## Engagement Impact of Using Email Verification vs Enforcing Use of Account Authentication

So this is about providing user convenience.  But from a user engagement point of view, providing such convenience might immediately lower the chance for a user to register an account.  This is most likely undesirable in the case of for-profit scenarios.

However, in non-profit word, especially small community groups, the perception may be that, when a user comes to the site to engage and  
 
 that might instead of increasing

### Join Membership Without Having to Log in or Explicitly Register   


## Model

Polymorphic (morph one) relationship between a verifiable model and `verification` model.

## Trait CanEmailVerify 

Add trait CanEmailVerify to a model to make it verifiable, by adding polymorphic morphOne relationship to the model.

TODO -- what exactly is in there ?

## Migration

Table `verifications`

## Route

Default route to verify any verifiable model `/email-verifiable/verify/{model}/{id}` 

## Flow

### Email with Signed URL 

When a verifiable model record is created via form submission by a guest, create a signed url and send to user by email.  So three criterion:

1.  Submitted via form 
2.  By a guest 
3.  Email included in the form 

**TODO -- UseEmailVerify trait not needed ??  Remove it ??**

### Signed URL Visited 

When the user received the email and clicked on the URL, the controller check if the signature is valid.  If invalid for any reason, then redirect user to a page.  **The page will explain the signature is not valid**, and offer to resend a verification email -- much like email verification for registration.

### Signed URL validated

Allow consumer of this package to attach middleware(s).  Whatever necessary after signed URL validation can be done this way.  
 
## Blade View Template

To override the default template, create your own 

- `resources/views/vendor/good-system/verified.blade.php`
- `resources/views/vendor/good-system/need-to-verify.blade.php`

Signed URL is created like this:
```
URL::temporarySignedRoute(
    'email-verifiable.verify', Carbon::now()->addMinutes(60), ['model' => $model, 'id' => $id] 
    // ['id' => $notifiable->getKey()]
)
```

Verification is done like this:
```
URL::hasValidSignature(Request $request)
```

## Trait CanEmailVerify


To make a model email-verifiable, trait `CanEmailVerify` should be used in the model, to 

- Add a one-to-one polymorphic relationship `verifiable`
- Add mutator `isVerified ` that serves as a proxy of this relationship 

`isVerified` means 

- either the relationship doesn't not exists
- or  

first install this package, then do the following.

