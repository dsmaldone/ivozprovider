<?php

namespace Ivoz\Cgr\Infrastructure\Cgrates\Service;

use GuzzleHttp\Exception\RequestException;
use Ivoz\Cgr\Domain\Service\TpCdrStat\FetchCallStatsServiceInterface;
use Ivoz\Provider\Domain\Model\Carrier\CarrierInterface;
use Ivoz\Provider\Domain\Model\Carrier\CarrierRepository;
use Graze\GuzzleHttp\JsonRpc\ClientInterface;

class FetchCallStatsService implements FetchCallStatsServiceInterface
{
    protected $client;
    protected $carrierRepository;

    public function __construct(
        ClientInterface $client,
        CarrierRepository $carrierRepository
    ) {
        $this->client = $client;
        $this->carrierRepository = $carrierRepository;
    }

    /**
     * @inheritdoc
     * @see FetchCallStatsServiceInterface::execute
     */
    public function execute(CarrierInterface $carrier)
    {
        $params = [
            'StatsQueueId' => $carrier->getCgrSubject()
        ];
        $response = $this->sendRequest(
            'CDRStatsV1.GetMetrics',
            $params
        );

        return $response->result;
    }

    /**
     * @inheritdoc
     * @see FetchCallStatsServiceInterface::getAsr
     */
    public function getAsr(int $carrierId)
    {
        $carrier = $this->carrierRepository->find($carrierId);
        $response =  $this->execute($carrier);

        return $response->ASR ?? null;
    }

    /**
     * @inheritdoc
     * @see FetchCallStatsServiceInterface::getAcd
     */
    public function getAcd(int $carrierId)
    {
        $carrier = $this->carrierRepository->find($carrierId);
        $response =  $this->execute($carrier);

        return $response->ACD ?? null;
    }

    private function sendRequest($method, $payload)
    {
        try {
            /** @var \Graze\GuzzleHttp\JsonRpc\Message\Response $request */
            $request = $this->client
                ->request(
                    1,
                    $method,
                    [$payload]
                );
        } catch (RequestException $e) {
            throw new \DomainException(
                "Unable to get information from Billing engine",
                40003,
                $e
            );
        }


        $response = $this->client->send($request);
        $responseObject = json_decode(
            $response->getBody()->__toString()
        );

        return $responseObject;
    }
}
