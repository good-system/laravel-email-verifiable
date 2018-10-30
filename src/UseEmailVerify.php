<?php
namespace GoodSystem\EmailVerifiable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

trait UseEmailVerify
{
    //  This trait provides functions to perform verification on any model by email.
    //  The process is similar to Laravel 5.7 built-in email verification.
    //  The assumption is that the model is set up to use CanEmailVerify trait (has a morphOne relation "verifiable").
/*
    protected function verify(Model $model)
    {
        if (method_exists($model, 'verifiable')) {

        }
        // Throw exception
    }
*/
    /**
     * @ param string $modelType
     * @ param integer $modelId
     * @ param array $extra -- extra key/value pair(s) to be appended to verification URL
     * @param array $params - usually contains model, id, email, verifyFor
     * @param integer $expiration
     * @return string
     */
    protected function getSignedUrl(array $params = [], $expiration = null)
    {
        if (! $expiration) {
            $expiration = config('email-verifiable.default-expiration', 60);
        }

        $signedUrl = URL::temporarySignedRoute(
            'email-verifiable.verify', Carbon::now()->addMinutes($expiration),
            $params
        );

        // A typical URL https://DOMAIN/email-verifiable/verify?expires=TIMESTAMP&signature=HASH_STRING&email=EMAIL&model=MODEL&id=NUMBER&verifyFor=Mailable_Class_Name
/*
        foreach ($params as $key => $value) {
            $signedUrl .= '&' . $key . '=' . $value;
        }
*/
        return $signedUrl;
    }
}