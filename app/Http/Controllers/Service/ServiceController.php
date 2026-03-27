<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Services\ServiceService;
use App\Models\Service;
use Illuminate\Container\Attributes\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Service::class);

        $services = $this->serviceService->listServices();

        return response()->json($services);
    }

    public function show(Service $service)
    {
        $this->authorize('view', $service);
        $services = $this->serviceService->findService($service);

        return response()->json($services);
    }

    public function store(ServiceRequest $request): Response
    {
        $this->authorize('create', Service::class);

        $this->serviceService->createService($request->validated());

        return response()->json(null, Response::HTTP_CREATED);
    }

    public function update(ServiceRequest $request, Service $service): Response
    {
        $this->authorize('update', $service);

        $updatedService = $this->serviceService->updateService($service->id, $request->validated());

        return response()->json(Response::HTTP_OK);
    }

    public function destroy(Service $service): Response
    {
        $this->authorize('update', $service);


        $service->delete();
        return response()->json(Response::HTTP_NO_CONTENT);
    }

    public function restore(Service $service): Response
    {
        $this->authorize('restore', $service);

        $service->restore();

        return response()->json(Response::HTTP_NO_CONTENT);
    }
}
