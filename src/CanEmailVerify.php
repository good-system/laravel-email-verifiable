<?php
namespace GoodSystem\EmailVerifiable;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait CanEmailVerify
{
    //  This trait adds a polymorphic relationship when used in a model.
    //  This is necessary for the model becomes email-verifiable.

    public function verifiable(): MorphOne
    {
        return $this->morphOne( \GoodSystem\EmailVerifiable\Verification::class, 'verifiable');
    }

    public function getIsVerifiedAttribute()
    {
        return (! $this->verifiable) || $this->verifiable->verified_at;
    }

    public function setIsVerifiedAttribute()
    {
        if (! $this->verifiable) {

        }
        return (! $this->verifiable) || $this->verifiable->verified_at;
    }
}
