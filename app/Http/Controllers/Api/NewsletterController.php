<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Services\Jobs\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{


    public function create(Request $request)
    {
        try {
            $input = $request->toArray();
            $email = data_get($input, 'email');
            $isEmail = Newsletter::where('email', $email)->first();
            if ($isEmail instanceof Newsletter) {
                return response()->json([
                    'success' => false,
                    'error' => 'You have already registered!'
                ], 400);
            }
            $newsletter = new Newsletter([
                'email' => $email
            ]);

            $newsletter->save();
            $data = [
                'from' => env('MAIL_FROM_ADDRESS'),
                'to' => $email
            ];
            //send mail queue
            Mail::dispatch($data);
            return response()->json([
                'success' => true
            ], 201);
        } catch (ValidationException $validationException) {
            return response()->json([
                'error' => $validationException->errors(),
                'success' => false
            ], 400);
        }

    }
}
