<?php

use App\Models\User;

test('create user with name and email', function () {

    // arrange
    $data = [
        'name' => 'Hany',
        'email' => 'hany@gmail.com',
        'password' => '12341234',
        'role' => 'Admin'
    ];


    //act
    $user = User::factory()->create($data);


    // assert
    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role
    ]);


});
