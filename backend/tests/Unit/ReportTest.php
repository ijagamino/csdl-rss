<?php

use App\Models\Report;
use App\Models\User;

test('it belongs to a user', function () {
    $user = User::factory()->create();

    $report = Report::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($report->user->is($user))->toBeTrue();
});

test('it has a status of pending, approved or completed', function () {
    $report = Report::factory()->create();

    expect($report->status)->toBeIn(['pending', 'approved', 'completed']);
});

test('it is deletable by owner', function () {
    $user = User::factory()->create();

    $report = Report::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->can('delete', $report))->toBeTrue();
});

test('it is not deletable by others', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $report = Report::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user2->can('delete', $report))->toBeFalse();
});

test('it is viewable by student', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $report = Report::factory()->create(['user_id' => $user->id]);

    expect($user->can('view', $report))->toBeTrue();
});

test('it is updatable by owner', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $report = Report::factory()->create(['user_id' => $user->id]);

    expect($user->can('update', $report))->toBeTrue();
});

test('it is updatable by staffs ', function () {
    $user = User::factory()->create([
        'role' => 'staff',
    ]);

    $report = Report::factory()->create();

    expect($user->can('update', $report))->toBeTrue();
});
