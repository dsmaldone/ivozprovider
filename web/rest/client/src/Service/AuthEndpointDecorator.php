<?php

namespace Service;

use Ivoz\Api\Swagger\Serializer\DocumentationNormalizer\AuthEndpointTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AuthEndpointDecorator implements NormalizerInterface
{
    use AuthEndpointTrait;

    /**
     * @var NormalizerInterface
     */
    protected $decoratedNormalizer;

    /**
     * @var \ArrayObject
     */
    protected $definitions;

    public function __construct(
        NormalizerInterface $decoratedNormalizer
    ) {
        $this->decoratedNormalizer = $decoratedNormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decoratedNormalizer->supportsNormalization(...func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $response = $this->decoratedNormalizer->normalize(...func_get_args());
        $paths = $response['paths']->getArrayCopy();

        $auth = [
            '/admin_login' => $this->getAdminLoginSpec(),
            '/user_login' => $this->getUserLoginSpec(),
            '/token/refresh' => $this->getTokenRefreshSpec()
        ];

        $response['paths'] = array_merge($auth, $paths);
        return $response;
    }
}
