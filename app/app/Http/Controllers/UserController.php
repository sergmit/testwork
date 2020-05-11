<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * User page
     *
     * @return Renderable
     */
    public function page(): Renderable
    {
        return view('users.index');
    }

    /**
     * Get all users
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return response()->json(UserResource::collection(User::all()));
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getUsers();

        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $request->validated();
        $user = $this->userService->createUser($request->all());

        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update(User $user, UserRequest $request): JsonResponse
    {
        $user = $this->userService->updateUser($user, $request->all());

        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->destroyUser($user);

        return response()->json(null, 204);
    }
}
