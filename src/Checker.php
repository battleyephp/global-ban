<?php

declare(strict_types=1);

namespace BattlEye\GlobalBan;

use BattlEye\GlobalBan\Exceptions\HostnameNotResolved;
use BattlEye\GlobalBan\Exceptions\SocketDataNotReceived;
use BattlEye\GlobalBan\Exceptions\SocketDataNotSent;
use BattlEye\GlobalBan\Exceptions\SocketNotCreated;
use BattlEye\GlobalBan\ValueObjects\GlobalBan;
use BattlEye\Guid\Guid;
use Socket;

final readonly class Checker implements Contracts\Checker
{
    public function __construct(
        private string $hostname = 'arma31.battleye.com',
        private int $port = 2344,
        private float $timeout = 0.5,
    ) {}

    /**
     * Check if the given GUID is banned.
     *
     * @throws HostnameNotResolved
     * @throws SocketDataNotSent
     * @throws SocketNotCreated
     * @throws SocketDataNotReceived
     */
    public function check(Guid $guid): GlobalBan
    {
        $data = $this->composeData($guid->toString());
        $reason = $this->sendData($data);

        return GlobalBan::fromReason($reason);
    }

    private function composeData(string $guid): string
    {
        return ".....$guid";
    }

    /**
     * @throws HostnameNotResolved
     * @throws SocketDataNotSent
     * @throws SocketNotCreated
     * @throws SocketDataNotReceived
     */
    private function sendData(string $data): string
    {
        $socket = $this->createSocket();

        $address = gethostbyname($this->hostname);
        $port = $this->port;

        if ($address === $this->hostname) {
            throw new HostnameNotResolved("Unable to resolve host: $address");
        }

        try {
            $sent = socket_sendto($socket, $data, mb_strlen($data), 0, $address, $port);

            if ($sent === false) {
                $error = socket_last_error();
                throw new SocketDataNotSent(socket_strerror($error), $error);
            }

            /** @noinspection PhpUnusedLocalVariableInspection */
            $receivedBytes = socket_recvfrom($socket, $receivedData, 1024, 0, $address, $port);

            /** @var string $receivedData */
            if ($receivedBytes === false) {
                $error = socket_last_error();
                throw new SocketDataNotReceived(socket_strerror($error), $error);
            }

            return mb_substr($receivedData, 4);
        } finally {
            socket_close($socket);
        }
    }

    /**
     * @throws SocketNotCreated
     */
    private function createSocket(): Socket
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if ($socket === false) {
            $error = socket_last_error();
            throw new SocketNotCreated(socket_strerror($error), $error);
        }

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 0, 'usec' => $this->timeout * 1000000]);
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => 0, 'usec' => $this->timeout * 1000000]);

        return $socket;
    }
}
