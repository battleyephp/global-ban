<?php

declare(strict_types=1);

use BattlEye\GlobalBan\ValueObjects\GlobalBan;

it('can be created', function () {
    $ban = GlobalBan::fromReason('');

    expect($ban)->toBeInstanceOf(GlobalBan::class);
});

it('exists if reason is not empty string', function () {
    $ban = GlobalBan::fromReason('test');

    expect($ban->exists)->toBeTrue();
});

it('does not exists if reason is empty string', function () {
    $ban = GlobalBan::fromReason('');

    expect($ban->exists)->toBeFalse();
});
