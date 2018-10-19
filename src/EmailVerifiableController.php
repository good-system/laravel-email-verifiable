<?php

namespace GoodSystem\EmailVerifiable;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EmailVerifiableController extends Controller
{
    use UseEmailVerify;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     *
     * @param Request $request
     * @param $model
     * @param $id
     * @return string
     */
    public function verify(Request $request, $model, $id)
    {
        if (URL::hasValidSignature($request)) {
            return view('good-system.email-verifiable::verified ', ['model' => $model, 'id' => $id]);
        } else {
            return view('good-system.email-verifiable::need-to-verify', ['model' => $model, 'id' => $id]);
        }
    }

    /**
     * @param Request $request
     * @param $model
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request, $model, $id)
    {
        $signedUrl = $this->getSignedUrl($model, $id);
        // TODO send email to user with the above signed URL, email view, etc. -- refer to template for resending registration verification email
        // TODO also make email sending queueable
        return back()->with('resent', true);
    }
}
