<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentRequest;
use App\Services\AppointmentService;
use App\Models\Appointment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected AppointmentService $service)
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }
    public function index()
    {

        $appointments = $this->service->listAllAppointments();

        return response()->json($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        return response()->json(
            $this->service->createAppointment($request->validated()),
            201
        );
    }

    public function updateStatus(AppointmentRequest $request, Appointment $appointment)
    {
        $updated = $this->service->updateStatus($appointment, $request->status);
        return response()->json($updated);
    }

    public function restore(int $id)
    {
        return response()->json($this->service->restoreAppointment($id));
    }
}
