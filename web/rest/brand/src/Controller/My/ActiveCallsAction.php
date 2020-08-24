<?php

namespace Controller\My;

use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use Ivoz\Kam\Domain\Service\TrunksClientInterface;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;
use Model\ActiveCalls;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ActiveCallsAction
{
    protected $tokenStorage;
    protected $requestStack;
    protected $trunksClient;
    protected $companyRepository;

    public function __construct(
        TokenStorage $tokenStorage,
        RequestStack $requestStack,
        TrunksClientInterface $trunksClient,
        CompanyRepository $companyRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->trunksClient = $trunksClient;
        $this->companyRepository = $companyRepository;
    }

    public function __invoke()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        $token =  $this->tokenStorage->getToken();

        if (!$token || !$token->getUser()) {
            throw new ResourceClassNotFoundException('User not found');
        }

        /** @var AdministratorInterface $user */
        $user = $token->getUser();
        $brand = $user->getBrand();

        $companyId = $request->get('company');
        if (!$companyId) {
            $activeCalls = $this
                ->trunksClient
                ->getBrandActiveCalls($brand->getId());

            return new ActiveCalls($activeCalls);
        }

        /** @var CompanyInterface | null $company */
        $company = $this->companyRepository->find($companyId);
        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }

        if ($company->getBrand() !== $brand) {
            throw new UnprocessableEntityHttpException('This company does not belong to your brand');
        }

        $activeCalls = $this
            ->trunksClient
            ->getCompanyActiveCalls(
                intval($companyId)
            );

        return new ActiveCalls($activeCalls);
    }
}
