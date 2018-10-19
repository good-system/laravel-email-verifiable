<?php
namespace GoodSystem\EmailVerifiable;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    // Reverse of Model@verifiable() is not defined here

    public function verify()
    {
        $this->verified_at = $this->freshTimestamp();
        $this->save();
    }
}
