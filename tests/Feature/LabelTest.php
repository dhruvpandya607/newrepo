<?php


test('fetching all labels', function () {

    $this->authUser();
    $this->createLabel(['user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $response = $this->getJson(route('label.index'))->json('data');

    $this->assertEquals(1, count($response));
});


test('storing a label with validation', function () {

    $this->authUser();
    $label = $this->createLabel();
    $this->withoutExceptionHandling();

    $storeLabelData = [
        'name' => $label->name, 'color' => $label->color, 'user_id' => auth()->id()
    ];
    $this->postJson(route('label.store'), $storeLabelData)->json('data');

    $this->assertDatabaseHas('labels', ['name' => $label->name, 'color' => $label->color]);
});


test('updating a label with validation', function () {

    $this->authUser();
    $label = $this->createLabel();
    $this->withoutExceptionHandling();

    $updateLabel = ['name' => 'second label', 'color' => 'blue'];

    $this->patchJson(route('label.update', $label->id), $updateLabel)->json('data');

    $this->assertDatabaseHas('labels', ['name' => 'second label', 'color' => 'blue']);
});


test('user can delete a label of task', function () {

    $this->authUser();
    $label = $this->createLabel(['user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $this->deleteJson(route('label.destroy', $label->id));

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
