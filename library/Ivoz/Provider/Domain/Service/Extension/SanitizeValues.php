<?php

namespace Ivoz\Provider\Domain\Service\Extension;

use Ivoz\Core\Domain\Service\EntityPersisterInterface;
use Ivoz\Provider\Domain\Model\Extension\ExtensionInterface;

/**
 * Class SanitizeValues
 * @package Ivoz\Provider\Domain\Service\Extension
 * @lifecycle pre_persist
 */
class SanitizeValues implements ExtensionLifecycleEventHandlerInterface
{
    /**
     * @var EntityPersisterInterface
     */
    protected $entityPersister;

    public function __construct(
        EntityPersisterInterface $entityPersister
    ) {
        $this->entityPersister = $entityPersister;
    }

    /**
     * @throws \Exception
     */
    public function execute(ExtensionInterface $entity, $isNew)
    {
        $nullableFields = array(
            "IvrCommon"     => "IvrCommon",
            "IvrCustom"     => "IvrCustom",
            "huntGroup"     => "huntGroup",
            "user"          => "user",
            "conferenceRoom" => "conferenceRoom",
            "number"        => "numberValue",
            "friend"        => "friendValue",
            "queue"         => "queue",
        );

        $routeType = $entity->getRouteType();
        foreach ($nullableFields as $type => $fieldName) {
            if ($routeType == $type) {
                continue;
            }

            $setter = "set" . ucfirst($fieldName);
            $entity->{$setter}(null);
        }
    }
}