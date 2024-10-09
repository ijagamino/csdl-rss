
<?php

use App\Models\Report;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

describe('role tests', function () {

    beforeEach(function () {
        $studentRole = Role::create(['name' => 'student']);
        $staffRole = Role::create(['name' => 'staff']);

        $createReports = Permission::create(['name' => 'create reports']);
        $viewOwnReports = Permission::create(['name' => 'view own reports']);
        $viewAllReports = Permission::create(['name' => 'view all reports']);

        $studentRole->givePermissionTo($createReports);
        $studentRole->revokePermissionTo($viewOwnReports);
        $staffRole->givePermissionTo($viewAllReports);

        $user = User::factory()->create();

        $this->student = User::factory()->create();
        $this->staff = User::factory()->create();

        $this->student->assignRole($studentRole);
        $this->staff->assignRole($staffRole);
        // $this->staff->givePermissionTo($createReports);
    });

    test('it has reports', function () {
        $report = Report::factory(3)->create([
            'user_id' => $this->student->id,
        ]);

        expect($this->student->reports()->count())->toBeInt();
    });

    test('student role can create reports', function () {
        expect($this->student->can('create reports'))->toBeTrue();
    });

    test('staff role cannot create a report', function () {

        expect($this->staff->can('create reports'))->toBeFalse();
    });

    test('staff role can view all reports', function () {
        expect($this->staff->can('view all reports'))->toBeTrue();
    });

    test('staffs permissions', function () {
        // dd($this->staff->getAllPermissions());
        // dd($this->student->getPermissionsViaRoles());
        dd($this->studentRole->permissions->pluck('name'));
    });
});
