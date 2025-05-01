<?php

declare(strict_types=1);

namespace BattlEye\GlobalBan\Contracts;

use BattlEye\GlobalBan\ValueObjects\GlobalBan;
use BattlEye\Guid\Guid;

interface Checker
{
    /**
     * Check if the given GUID is banned.
     */
    public function check(Guid $guid): GlobalBan;
}
