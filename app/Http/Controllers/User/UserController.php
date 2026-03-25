<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\{PaginationRequest, StoreUserRequest, ToggleStatusUserRequest, UpdateUserRequest};
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\{Role, User};
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private UserService $service) {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(PaginationRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getAll($request),
            Response::HTTP_OK
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->create($request),
            Response::HTTP_CREATED
        );
    }

    public function show(User $user): JsonResponse
    {

        return response()->json(
            $this->service->getById($user),
            Response::HTTP_OK
        );
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return response()->json(
            $this->service->update($user, $request->validated()),
            Response::HTTP_OK
        );
    }

    public function destroy(User $user): Response
    {
        $this->service->delete($user);
        return response()->noContent();
    }

    public function forceDelete(User $user): Response
    {
        $this->authorize('forceDelete', $user);
        $this->service->forceDelete($user);
        return response()->noContent();
    }

    public function restore(User $user): JsonResponse
    {
        $this->authorize('restore', User::class);
        return response()->json(
            $this->service->restore($user),
            Response::HTTP_OK
        );
    }

    public function toggleStatus(ToggleStatusUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $this->service->toggleStatus($user, $request->validated());

        return response()->json(Response::HTTP_OK);
    }

    public function roles(): JsonResponse
    {
        $this->authorize('update-user-role', User::class);

        return response()->json(
            RoleResource::collection($this->service->roles()),
            Response::HTTP_OK
        );
    }

    public function updateRole(User $user, Role $role): JsonResponse
    {
        $this->authorize('update-user-role', $user);

        return response()->json(
            $this->service->updateRole($user, $role),
            Response::HTTP_OK
        );
    }
}
