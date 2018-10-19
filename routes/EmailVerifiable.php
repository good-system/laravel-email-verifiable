<?php

Route::prefix(config('email-verifiable.path-root'))->group(function () {
    Route::get('email-verifiable/resend/{model}/{id}', '\GoodSystem\EmailVerifiable\EmailVerifiableController@resend')
        ->name('email-verifiable.resend');

    Route::get('email-verifiable/verify/{model}/{id}', '\GoodSystem\EmailVerifiable\EmailVerifiableController@verify')
        ->name('email-verifiable.verify')->middleware('email-verifiable.verified');
});