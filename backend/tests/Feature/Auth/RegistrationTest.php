<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'username' => 'Test User',
        'email' => 'test@example.com',
        'first_name' => 'Test',
        'last_name' => 'user',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
