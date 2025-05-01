<?php

declare(strict_types=1);

use BattlEye\GlobalBan\Checker;
use BattlEye\GlobalBan\Exceptions\HostnameNotResolved;
use BattlEye\Guid\Guid;

it('can be created with default parameters', function () {
    $checker = new Checker();

    expect($checker)->toBeInstanceOf(Checker::class);
});

it('throws exception if hostname is not resolved', function () {
    $checker = new Checker('battleye.battleye.test');

    $checker->check(Guid::fromString('098f6bcd4621d373cade4e832627b4f6'));
})->throws(HostnameNotResolved::class);
