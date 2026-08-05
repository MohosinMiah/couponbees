<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    public const EMAIL = 'partnerships@couponterra.com';

    public function show()
    {
        $meta = [
            'title'       => 'Contact Us - ' . config('app.name'),
            'description' => 'Get in touch with ' . config('app.name') . ' for partnerships, coupon corrections, or general support.',
        ];

        return view('pages.contact', ['email' => self::EMAIL, 'meta' => $meta]);
    }
}
