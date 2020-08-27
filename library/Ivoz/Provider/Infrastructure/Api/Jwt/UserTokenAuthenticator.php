<?php

namespace Ivoz\Provider\Infrastructure\Api\Jwt;

use Ivoz\Provider\Domain\Model\User\User;
use Ivoz\Provider\Infrastructure\Api\Security\User\MutableUserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserTokenAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @var JWTTokenManagerInterface
     */
    protected $jwtManager;

    protected $tokenStorage;

    /**
     * @param JWTTokenManagerInterface $jwtManager
     * @param EventDispatcherInterface $dispatcher
     * @param TokenExtractorInterface  $tokenExtractor
     */
    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        TokenExtractorInterface $tokenExtractor,
        TokenStorage $tokenStorage
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorage = $tokenStorage;

        parent::__construct($jwtManager, $dispatcher, $tokenExtractor);
    }

    public function supports(Request $request)
    {
        $canExtractToken = parent::supports($request);
        if (!$canExtractToken) {
            return false;
        }

        $payload =  $this->getCredentials($request)->getPayload();
        $roles = $payload['roles'] ?? [];

        $isCompanyUser = in_array('ROLE_COMPANY_USER', $roles, true);

        return $isCompanyUser;
    }

    /**
     * @inheritdoc
     */
    public function getUser($preAuthToken, UserProviderInterface $userProvider)
    {
        if (!$preAuthToken instanceof PreAuthenticationJWTUserToken) {
            throw new \InvalidArgumentException(
                sprintf('The first argument of the "%s()" method must be an instance of "%s".', __METHOD__, PreAuthenticationJWTUserToken::class)
            );
        }

        $payload = $preAuthToken->getPayload();
        if (in_array('ROLE_COMPANY_USER', $payload['roles'])) {
            $this->jwtManager->setUserIdentityField('email');
        }

        $user = parent::getUser(...func_get_args());
        if ($user) {
            $this->tokenStorage->setToken($preAuthToken);
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    protected function loadUser(UserProviderInterface $userProvider, array $payload, $identity)
    {
        if (!$userProvider instanceof MutableUserProviderInterface) {
            throw new \RuntimeException(
                'MutableUserProviderInterface was espected in order to load a user'
            );
        }

        /** @var MutableUserProviderInterface $userProvider */
        $userProvider
            ->setEntityClass(User::class)
            ->setUserIdentityField('email');

        return $userProvider->loadUserByUsername($identity);
    }
}
