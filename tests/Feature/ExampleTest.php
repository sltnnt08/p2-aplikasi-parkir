<?php

test('guest redirected to login from root path', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
