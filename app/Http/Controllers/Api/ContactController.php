<?php
namespace App\Http\Controllers\Api;

use App\Mail\SupportContact;
use App\Http\Requests\Mail\ContactMailRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function send(ContactMailRequest $request): Response
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        Mail::to(config('mail.from.address'))
            ->send(new SupportContact($validated));

        return response(null, Response::HTTP_OK);
    }
}
