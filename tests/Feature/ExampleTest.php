<?php

<<<<<<< HEAD
it('returns a successful response', function () {
=======
test('the application returns a successful response', function () {
>>>>>>> 8a516920b106a74f14a1134993a0609060f01a40
    $response = $this->get('/');

    $response->assertStatus(200);
});
