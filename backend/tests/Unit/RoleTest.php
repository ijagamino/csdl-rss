
<?php

use App\Models\Report;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('it has reports', function () {
    $user = User::factory()->create();

    $report = Report::factory(3)->create([
        'user_id' => $user->id,
    ]);

    expect($user->reports()->count())->toBeInt();
});

test('student role can create reports', function () {
    $role = Role::create(['name' => 'student']);
    $permission = Permission::create(['name' => 'create reports']);

    $role->givePermissionTo($permission);
    $user = User::factory()->create([]);

    $user->assignRole($role);

    $user2 = User::factory()->create([]);

    dd($user2->getRoleNames());

    expect($user->can('create reports'))->toBeTrue();
});

test('staffs cannot create a report', function () {
    $user = User::factory()->create([
        'role' => 'staff',
    ]);

    expect($user->can('create', Report::class))->toBeFalse();
});

test('staffs can view all reports', function () {
    $user = User::factory()->create([
        'role' => 'staff',
    ]);

    expect($user->can('viewAny', Report::class))->toBeTrue();
});
