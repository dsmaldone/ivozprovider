<?php

namespace Ivoz\Kam\Infrastructure\Gearman;

use Ivoz\Core\Infrastructure\Domain\Service\Gearman\Client\AbstractXmlRpcRequest;
use Ivoz\Core\Infrastructure\Domain\Service\Gearman\Client\XmlRpcUsersRequestInterface;
use Ivoz\Core\Infrastructure\Domain\Service\Gearman\Jobs\Xmlrpc;
use Ivoz\Kam\Domain\Service\UsersClientInterface;
use Ivoz\Provider\Domain\Model\ProxyUser\ProxyUser;

class XmlRpcUsersRequest extends AbstractXmlRpcRequest implements XmlRpcUsersRequestInterface
{

    public function __construct(
        Xmlrpc $xmlrpc,
        bool $enabled
    ) {
        parent::__construct(
            $xmlrpc,
            ProxyUser::class,
            8000,
            $enabled
        );
    }

    public function send(string $action)
    {
        if (!in_array($action, UsersClientInterface::USERS_ACTIONS, true)) {
            throw new \RuntimeException('Unexpected method ' . $action);
        }

        parent::send($action);
    }
}
