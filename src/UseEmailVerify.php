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
     * @param string $modelType
     * @param integer $modelId
     * @param array $extra -- extra key/value pair(s) to be appended to verification URL
     * @param integer $expiration
     * @return string
     */
    protected function getSignedUrl($modelType, $modelId, array $extra = [], $expiration = null)
    {
        if (! $expiration) {
            $expiration = config('email-verifiable.default-expiration', 60);
        }

        $signedUrl = URL::temporarySignedRoute(
            'email-verifiable.verify', Carbon::now()->addMinutes($expiration), ['model' => strtolower($modelType), 'id' => $modelId]
        );

        foreach ($extra as $key => $value) {
            $signedUrl .= '&' . $key . '=' . $value;
        }

        $signedUrl .= '&model=' . $modelType;
        $signedUrl .= '&id=' . $modelId;

        return $signedUrl;
    }
}