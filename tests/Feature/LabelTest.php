<?php


test('fetching all labels', function () {

    $this->authUser();
    $user = $this->createUser();
    $label = $this->createLabel(['user_id' => $user->id]);

    $this->withoutExceptionHandling();

    $response = $this->getJson(route('label.index'))->json();

    $this->assertEquals(1, count($response));
});


test('creating a label', function () {

    $this->authUser();
    $user = $this->createUser();
    $label = $this->createLabel(['user_id' => $user->id]);

    $this->withoutExceptionHandling();

    $this->getJson(route('label.create'))->assertOK();
});


test('storing a label with validation', function () {

    $this->authUser();
    $user = $this->createUser();
    $label = $this->createLabel(['user_id' => $user->id]);

    $this->withoutExceptionHandling();

    $this->postJson(route('label.store'), [
        'name' => $label->name, 'color' => $label->color, 'user_id' => $user->id
    ]);

    $this->assertDatabaseHas('labels', ['name' => $label->name, 'color' => $label->color]);
});


test('updating a label with validation', function () {

    $this->authUser();
    $user = $this->createUser();
    $label = $this->createLabel(['user_id' => $user->id]);

    $this->withoutExceptionHandling();

    $this->patchJson(route('label.update', $label->id), ['name' => 'second label', 'color' => 'blue']);

    $this->assertDatabaseHas('labels', ['name' => 'second label', 'color' => 'blue']);
});


test('user can delete a label of task', function () {

    $this->authUser();
    $user = $this->createUser();
    $label = $this->createLabel(['user_id' => $user->id]);

    $this->withoutExceptionHandling();

    $this->deleteJson(route('label.destroy', $label->id));

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
