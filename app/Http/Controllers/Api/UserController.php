<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse
    {
        $users = $this->userRepository->all();

        if ($users->isEmpty()) {
            return response()->json(
                [
                    'message' => 'No users found',
                ],
                404,
            );
        }

        return response()->json([
            $users,
        ]);
    }

    public function show($id): JsonResponse
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(
                [
                    'message' => 'Invalid user ID',
                ],
                400,
            );
        }

        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                return response()->json(
                    [
                        'message' => 'User not found',
                    ],
                    404,
                );
            }

            return response()->json([
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while retrieving the user',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => 'Invalid data',
                    'errors' => $validate->errors(),
                ],
                400,
            );
        }

        try {
            $userData = $request->only(['first_name', 'last_name', 'phone_number', 'email', 'password']);
            $user = $this->userRepository->create($userData);

            return response()->json(
                [
                    $user,
                ],
                201,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while creating the user',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(
                [
                    'message' => 'Invalid user ID',
                ],
                400,
            );
        }

        $validate = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => 'Invalid data',
                    'errors' => $validate->errors(),
                ],
                400,
            );
        }

        try {
            $userData = $request->only(['first_name', 'last_name', 'phone_number']);
            $user = $this->userRepository->updateById($id, $userData);

            if (!$user) {
                return response()->json(
                    [
                        'message' => 'User not found',
                    ],
                    404,
                );
            }

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while updating the user',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id): JsonResponse
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(
                [
                    'message' => 'Invalid user ID',
                ],
                400,
            );
        }

        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                return response()->json(
                    [
                        'message' => 'User not found',
                    ],
                    404,
                );
            }

            $this->userRepository->deleteById($id);

            return response()->json([
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while deleting the user',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
