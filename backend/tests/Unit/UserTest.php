<?php

use App\Models\Report;
use App\Models\User;

test('it has reports', function () {
    $user = User::factory()->create();

    $report = Report::factory(3)->create([
        'user_id' => $user->id,
    ]);

    expect($user->reports()->count())->toBeInt();
});

test('students can create a report', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    expect($user->can('create', Report::class))->toBeTrue();
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
