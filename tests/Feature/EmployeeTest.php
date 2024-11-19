<?php

namespace Tests\Feature;

use App\Jobs\CreateEmployeesFromListJob;
use App\Jobs\ProcessEmployeesListJob;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $manager = User::Factory()->create();
        $this->manager = $manager;
        (new Passport)::actingAs($this->manager);
    }

    public function testCreateEmployee(): void
    {
        (new Passport)::actingAs($this->manager);
        $payload = Employee::factory()->make()->toArray();

        $response = $this->postJson(route('employee.create', $payload));

        $response->assertCreated();
        $parsedCpf = preg_replace('/\D/', '', $payload['cpf']);
        $response->assertJsonFragment([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'cpf' => $parsedCpf,
            'city' => $payload['city'],
            'state' => $payload['state'],
            'manager_id' => $this->manager->id,
        ]);

        $employeeCreated = Employee::query()->where('email', $payload['email'])->first();

        $this->assertDatabaseHas(Employee::class,
            [
                'name' => $employeeCreated->name,
                'email' => $employeeCreated->email,
                'id' => $employeeCreated->id,
                'manager_id' => $this->manager->id,
            ]
        );
    }

    public function testListEmployees(): void
    {
        $this->seed();

        $manager = User::factory()->create();

        Employee::query()->update(['manager_id' => $manager->id]);

        $this->assertDatabaseCount(Employee::class, 150);
        // 1 user criado no setup, o segundo no seeder e o terceiro aqui
        $this->assertDatabaseCount(User::class, 3);
        $employeesOfManagerBefore = Employee::query()
            ->where('manager_id', $manager->id)->count();

        $this->assertSame(
            Employee::query()->count(),
            $employeesOfManagerBefore
        );

        // alterando o manager_id para diferente do manager atual
        Employee::query()
            ->limit(5)
            ->update(['manager_id' => $this->manager->id]);

        $employeesOfManagerAfter = Employee::query()
            ->where('manager_id', $manager->id)->count();

        $this->assertEqualsWithDelta(
            $employeesOfManagerBefore,
            $employeesOfManagerAfter,
            5
        );

        (new Passport)::actingAs($manager);

        $response = $this->getJson(route('employee.list'));

        $response->assertOk();

        $this->assertJson($response->getContent());

        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'name',
                        'email',
                        'cpf',
                        'city',
                        'state',
                        'manager_id',
                        'deleted_at',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]
        );
    }

    public function testUpdateEmployee(): void
    {
        (new Passport)::actingAs($this->manager);
        $employee = Employee::factory()->create(
            ['manager_id' => $this->manager->id]
        );

        $employeeCpfBefore = $employee->cpf;

        $toUpdate = '123.456.789-99';

        $payload = [
            'name' => $employee->name,
            'cpf' => $toUpdate,
            'city' => $employee->city,
            'state' => $employee->state,
            'email' => $employee->email,
        ];

        $response = $this->putJson(
            route('employee.edit', $employee->id),
            $payload
        );

        $response->assertOk();

        $employee->refresh();

        $this->assertNotSame($employeeCpfBefore, $employee->cpf);

        $this->assertNotSame($employee->created_at, $employee->updated_at);
    }

    public function testDeleteEmployee(): void
    {
        (new Passport)::actingAs($this->manager);
        $employee = Employee::factory()->create(
            ['manager_id' => $this->manager->id]
        );

        $numberOfEmployeesBefore = Employee::query()->count();

        $response = $this->deleteJson(route('employee.delete', $employee->id));

        $response->assertOk();

        $numberOfEmployeesAfter = Employee::query()->count();

        $this->assertEqualsWithDelta(
            $numberOfEmployeesBefore,
            $numberOfEmployeesAfter,
            1
        );

        $deleted = Employee::query()->withTrashed()->where('id', $employee->id)->first();

        $this->assertSoftDeleted($deleted);
    }

    /**
     * @throws Exception
     */
    public function testListUpload(): void
    {
        Storage::fake('test');

        (new Passport)::actingAs($this->manager);

        $csvData = $this->dataForFakeCSV();
        $csvFile = UploadedFile::fake()->createWithContent('test.csv', $csvData);
        $csvFile->storeAs('uploads', $csvFile->getClientOriginalName(), 'test');

        $response = $this->post(
            route('employee.upload-list'),
            ['list' => $csvFile]
        );

        $response->assertOk();
        $response->assertJsonPath('message', 'A lista está sendo processada. Você receberá um email assim que o processo terminar.');

        Storage::disk('test')->assertExists("uploads/{$csvFile->getClientOriginalName()}");

        $this->createStub(ProcessEmployeesListJob::class);
        $this->createStub(CreateEmployeesFromListJob::class);
    }

    private function dataForFakeCSV(): string
    {
        $fakeData = Employee::factory(500)->make();
        $csv = "name,email,cpf,city,state\n";
        foreach ($fakeData as $data) {
            $csv .= "$data->name,$data->email,$data->cpf,$data->city,$data->state\n";
        }

        return $csv;
    }
}
