<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class UserAuthController extends Controller
{
    use ApiResponse;
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:50',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|same:password',
            ]);

            $user = $this->userRepository->create($request->name, $request->email, $request->password);

            return $this->sendResponse($user, 'Registration successful');
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return $this->sendError('Validation Error', $errors, 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (Auth::attempt($data)) {
                $user = Auth::user();
                $user['token'] =  $user->createToken('hjdfgbdjkk')->accessToken;
                return $this->sendResponse($user, 'User login successfully');
            } else {
                return $this->sendError('Invalid email/password');
            }
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return $this->sendError('Validation Error', $errors, 422);
        }
    }
}
