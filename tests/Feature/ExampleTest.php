<?php

test('a API está funcionando', function () {
    $response = $this->getJson('/api/metas');

    $response->assertStatus(401);
});