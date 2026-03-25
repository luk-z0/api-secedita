<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Services\UserService;

class RegisteredUserController extends Controller
{

    public function __construct(private UserService $userService) {}

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */

    public function store(RegisteredUserRequest $request): Response
    {
        $user = $this->userService->register($request);

        Auth::login($user);

        return response()->noContent();
    }
}
