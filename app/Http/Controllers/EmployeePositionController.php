<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeePosition\DestroyEmployeePositionRequest;
use App\Http\Requests\EmployeePosition\StoreOrUpdateEmployeePositionRequest;
use App\Http\Resources\EmployeePosition\EmployeePositionCollection;
use App\Models\EmployeePosition;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class EmployeePositionController extends Controller
{
    public function index()
    {
        $positions = EmployeePosition::query()->orderByDesc('created_at')->paginate(10);
        return response()->json(new EmployeePositionCollection($positions));
    }

    public function store(StoreOrUpdateEmployeePositionRequest $request)
    {
        EmployeePosition::query()->create($request->toArray());
        return response()->noContent(HttpStatus::HTTP_CREATED);
    }

    public function update(EmployeePosition $employeePosition, StoreOrUpdateEmployeePositionRequest $request)
    {
        $employeePosition->update($request->toArray());
        return response()->noContent(HttpStatus::HTTP_OK);
    }

    public function destroy(EmployeePosition $employeePosition, DestroyEmployeePositionRequest $request)
    {
        $employeePosition->delete();
        return response()->noContent(HttpStatus::HTTP_OK);
    }

}
