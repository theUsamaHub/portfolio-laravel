<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\SiteSetting;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ) {}

    public function store(StoreContactMessageRequest $request)
    {
        // Validate reCAPTCHA only if enabled AND keys are configured
        $isEnabled = SiteSetting::get('enable_recaptcha', false);
        $siteKey = SiteSetting::get('recaptcha_site_key', '');
        $secretKey = SiteSetting::get('recaptcha_secret_key', '');

        if ($isEnabled && !empty($siteKey) && !empty($secretKey)) {
            $captchaResponse = $request->input('g-recaptcha-response');
            if (!$captchaResponse || !$this->verifyRecaptcha($captchaResponse, $secretKey)) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'reCAPTCHA verification failed. Please try again.'], 422);
                }
                return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
            }
        }

        $this->contactService->store($request->validated());

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Thank you for your message. I will get back to you soon.']);
        }

        return back()->with('success', 'Thank you for your message. I will get back to you soon.');
    }

    private function verifyRecaptcha(string $response, string $secret): bool
    {
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query([
                    'secret' => $secret,
                    'response' => $response,
                    'remoteip' => request()->ip(),
                ]),
            ],
        ]));

        $result = json_decode($verify, true);
        return $result['success'] ?? false;
    }
}
