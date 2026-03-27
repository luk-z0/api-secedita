<?php
namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Services\ServiceService;
use App\Models\Service;
use Illuminate\Container\Attributes\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService
    ) {
        $this->authorizeResource(Service::class, 'service');
    }

    public function index(ServiceRequest $request)
    {

        $services = $this->serviceService->listServices();

        return response()->json($services);
    }

    public function store(ServiceRequest $request):Response
    {
        $this->serviceService->createService($request->validated());

        return response()->json(null,Response::HTTP_CREATED);
    }



    public function update(ServiceRequest $request, int $id): Response
    {
        $this->serviceService->updateService($id, $request->validated());

        return response()->json(Response::HTTP_OK);
    }

    public function destroy(Service $service):Response
    {

        $service->delete();
        return response()->json(Response::HTTP_NO_CONTENT);
    }

    public function restore(Service $service): Response
    {
        $service->restore();

        return response()->json(Response::HTTP_NO_CONTENT);
    }
}
