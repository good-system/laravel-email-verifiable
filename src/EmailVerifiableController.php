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
     * @ param $model
     * @ param $id
     * @return string
     */
    public function verify(Request $request)
    {
        // Middleware should be defined in "consumers" of this package, and terminate upon successful execution.
        // This is the fall back of everything
        if ($this->getFullMailableClassName($request->query('verifyFor'))) {
            if (! $request->hasValidSignature()) {
                //  Invalid signature -- display generic message that says email verification failed
                return view('good-system.email-verifiable::verification-failed', ['data' => $request->query->all()]);
            }
        }

        // URL query parameter "verifyFor" doesn't indicate a specific verification purpose.  It doesn't matter if the signature is valid.
        // Display generic message that says something like "email verification purpose not specified"
        return view('good-system.email-verifiable::no-specific-purpose');

/*
        if (URL::hasValidSignature($request)) {
            return view('good-system.email-verifiable::verified ', ['model' => $model, 'id' => $id]);
        } else {
            return view('good-system.email-verifiable::need-to-verify', ['model' => $model, 'id' => $id]);
        }*/
    }

    /**
     * @param Request $request
     * @param $model
     * @param $id
     * @param $verifyFor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request, $model, $id, $verifyFor)
    {
        // $signedUrl = $this->getSignedUrl(['model' => $model, 'id' => $id, 'verifyFor' => $verifyFor]);

        // TODO send email to user with the above signed URL, email view, etc. -- refer to template for resending registration verification email
        // Determine what mailable to use by verifyFor
        // TODO also make email sending queueable
        // return 'TO BE IMPLEMENTED'; // back()->with('resent', true);


        // TODO find out the full class name from verifyFor, then try to send an email assuming it represents a mailable.
        try {
            return view('good-system.email.verifiable::verification-email-resent', ['data' => $request->query->all()]);
        } catch(\Exception $e) {
            return view('good-system.email.verifiable::no-specific-purpose', ['data' => $request->query->all()]);
        }
        /*
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, '\Illuminate\Mail\Mailable'))
                echo $class . '<hr>';
        }
        */

    }

    protected function getFullMailableClassName($verifyFor)
    {
        // TODO find out the full class name from verifyFor
        return $verifyFor;
    }
}
