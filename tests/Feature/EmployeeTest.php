<?php

use App\Models\Employee;
use App\Models\EmployeePosition;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

BeforeEach(function () {
    $this->loginAsUser();
});
BeforeEach(function () {
    $this->loginAsUser();
    EmployeePosition::factory()->create();
    $this->founder = Employee::factory()->create([
        'name' => 'Yad | Founder',
        'email' => 'founder@example.com',
        'manager_id' => null,
    ]);

    $this->firstLevelManagers = Employee::factory(2)->create([
        'manager_id' => $this->founder->id,
    ]);

    $this->secondLevelManagers = Employee::factory(3)->create([
        'manager_id' => 2,
    ]);
    $this->secondLevelManagers = Employee::factory(3)->create([
        'manager_id' => 3,
    ]);
});

it('returns a list of employees', function () {

    $response = $this->getJson(route('api.v1.employee-positions.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name']
        ],
        'meta' => [
            'current_page',
            'last_page',
            'per_page',
            'total',
        ]
    ]);
});

it('returns employee hierarchy', function () {


    $response = $this->getJson(route('api.v1.employees.hierarchy', $this->firstLevelManagers[0]->id));

    $response->assertOk();
    $response->assertJsonStructure(['data']);
});

it('returns employee hierarchy with salaries', function () {

    $response = $this->getJson(route('api.v1.employees.hierarchy-with-salaries', $this->firstLevelManagers[0]->id));

    $response->assertOk();
    $response->assertJsonStructure(['data']);
});

it('returns employees without recent salary change', function () {

    $response = $this->getJson(route('api.v1.employees.without-recent-salary-change', [
        'months' => 6
    ]));

    $response->assertOk();
    $response->assertJsonStructure(['data']);
});


it('creates a new employee', function () {

    $payload = Employee::factory()->make()->toArray();
    $payload['is_founder'] = true;
    unset($payload['manager_id']);

    $response = $this->postJson(route('api.v1.employees.store', $payload));

    $response->assertStatus(HttpStatus::HTTP_CREATED);
});

it('updates a existing employee', function () {


    $payload = Employee::factory()->create()->toArray();
    $payload['name'] = 'New Name';
    $payload['email'] = 'nottaken@example.com';
    $payload['is_founder'] = false;
    $payload['manager_id'] = $this->firstLevelManagers[1]->id;

    $response = $this->putJson(route('api.v1.employees.update', ['employee' => $this->firstLevelManagers[0]->id] ), $payload);

    $response->assertStatus(HttpStatus::HTTP_NO_CONTENT);

});

it('deletes an employee', function () {


    $response = $this->deleteJson(route('api.v1.employees.destroy', ['employee' => $this->secondLevelManagers[0]->id]));
    $response->assertOk();
});
