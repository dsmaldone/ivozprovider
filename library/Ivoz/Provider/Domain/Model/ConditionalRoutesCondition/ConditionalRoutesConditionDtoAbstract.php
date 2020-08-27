<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoutesCondition;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class ConditionalRoutesConditionDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $priority = 1;

    /**
     * @var string
     */
    private $routeType;

    /**
     * @var string
     */
    private $numberValue;

    /**
     * @var string
     */
    private $friendValue;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto | null
     */
    private $conditionalRoute;

    /**
     * @var \Ivoz\Provider\Domain\Model\Ivr\IvrDto | null
     */
    private $ivr;

    /**
     * @var \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto | null
     */
    private $huntGroup;

    /**
     * @var \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    private $voicemailUser;

    /**
     * @var \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    private $user;

    /**
     * @var \Ivoz\Provider\Domain\Model\Queue\QueueDto | null
     */
    private $queue;

    /**
     * @var \Ivoz\Provider\Domain\Model\Locution\LocutionDto | null
     */
    private $locution;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto | null
     */
    private $conferenceRoom;

    /**
     * @var \Ivoz\Provider\Domain\Model\Extension\ExtensionDto | null
     */
    private $extension;

    /**
     * @var \Ivoz\Provider\Domain\Model\Country\CountryDto | null
     */
    private $numberCountry;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelMatchlist\ConditionalRoutesConditionsRelMatchlistDto[] | null
     */
    private $relMatchlists = null;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelSchedule\ConditionalRoutesConditionsRelScheduleDto[] | null
     */
    private $relSchedules = null;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelCalendar\ConditionalRoutesConditionsRelCalendarDto[] | null
     */
    private $relCalendars = null;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelRouteLock\ConditionalRoutesConditionsRelRouteLockDto[] | null
     */
    private $relRouteLocks = null;


    use DtoNormalizer;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'priority' => 'priority',
            'routeType' => 'routeType',
            'numberValue' => 'numberValue',
            'friendValue' => 'friendValue',
            'id' => 'id',
            'conditionalRouteId' => 'conditionalRoute',
            'ivrId' => 'ivr',
            'huntGroupId' => 'huntGroup',
            'voicemailUserId' => 'voicemailUser',
            'userId' => 'user',
            'queueId' => 'queue',
            'locutionId' => 'locution',
            'conferenceRoomId' => 'conferenceRoom',
            'extensionId' => 'extension',
            'numberCountryId' => 'numberCountry'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'priority' => $this->getPriority(),
            'routeType' => $this->getRouteType(),
            'numberValue' => $this->getNumberValue(),
            'friendValue' => $this->getFriendValue(),
            'id' => $this->getId(),
            'conditionalRoute' => $this->getConditionalRoute(),
            'ivr' => $this->getIvr(),
            'huntGroup' => $this->getHuntGroup(),
            'voicemailUser' => $this->getVoicemailUser(),
            'user' => $this->getUser(),
            'queue' => $this->getQueue(),
            'locution' => $this->getLocution(),
            'conferenceRoom' => $this->getConferenceRoom(),
            'extension' => $this->getExtension(),
            'numberCountry' => $this->getNumberCountry(),
            'relMatchlists' => $this->getRelMatchlists(),
            'relSchedules' => $this->getRelSchedules(),
            'relCalendars' => $this->getRelCalendars(),
            'relRouteLocks' => $this->getRelRouteLocks()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    /**
     * @param integer $priority
     *
     * @return static
     */
    public function setPriority($priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $routeType
     *
     * @return static
     */
    public function setRouteType($routeType = null)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * @param string $numberValue
     *
     * @return static
     */
    public function setNumberValue($numberValue = null)
    {
        $this->numberValue = $numberValue;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getNumberValue()
    {
        return $this->numberValue;
    }

    /**
     * @param string $friendValue
     *
     * @return static
     */
    public function setFriendValue($friendValue = null)
    {
        $this->friendValue = $friendValue;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getFriendValue()
    {
        return $this->friendValue;
    }

    /**
     * @param integer $id
     *
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto $conditionalRoute
     *
     * @return static
     */
    public function setConditionalRoute(\Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto $conditionalRoute = null)
    {
        $this->conditionalRoute = $conditionalRoute;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto | null
     */
    public function getConditionalRoute()
    {
        return $this->conditionalRoute;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setConditionalRouteId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto($id)
            : null;

        return $this->setConditionalRoute($value);
    }

    /**
     * @return mixed | null
     */
    public function getConditionalRouteId()
    {
        if ($dto = $this->getConditionalRoute()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Ivr\IvrDto $ivr
     *
     * @return static
     */
    public function setIvr(\Ivoz\Provider\Domain\Model\Ivr\IvrDto $ivr = null)
    {
        $this->ivr = $ivr;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Ivr\IvrDto | null
     */
    public function getIvr()
    {
        return $this->ivr;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setIvrId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Ivr\IvrDto($id)
            : null;

        return $this->setIvr($value);
    }

    /**
     * @return mixed | null
     */
    public function getIvrId()
    {
        if ($dto = $this->getIvr()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto $huntGroup
     *
     * @return static
     */
    public function setHuntGroup(\Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto $huntGroup = null)
    {
        $this->huntGroup = $huntGroup;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto | null
     */
    public function getHuntGroup()
    {
        return $this->huntGroup;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setHuntGroupId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto($id)
            : null;

        return $this->setHuntGroup($value);
    }

    /**
     * @return mixed | null
     */
    public function getHuntGroupId()
    {
        if ($dto = $this->getHuntGroup()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\User\UserDto $voicemailUser
     *
     * @return static
     */
    public function setVoicemailUser(\Ivoz\Provider\Domain\Model\User\UserDto $voicemailUser = null)
    {
        $this->voicemailUser = $voicemailUser;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    public function getVoicemailUser()
    {
        return $this->voicemailUser;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setVoicemailUserId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\User\UserDto($id)
            : null;

        return $this->setVoicemailUser($value);
    }

    /**
     * @return mixed | null
     */
    public function getVoicemailUserId()
    {
        if ($dto = $this->getVoicemailUser()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\User\UserDto $user
     *
     * @return static
     */
    public function setUser(\Ivoz\Provider\Domain\Model\User\UserDto $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setUserId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\User\UserDto($id)
            : null;

        return $this->setUser($value);
    }

    /**
     * @return mixed | null
     */
    public function getUserId()
    {
        if ($dto = $this->getUser()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Queue\QueueDto $queue
     *
     * @return static
     */
    public function setQueue(\Ivoz\Provider\Domain\Model\Queue\QueueDto $queue = null)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Queue\QueueDto | null
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setQueueId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Queue\QueueDto($id)
            : null;

        return $this->setQueue($value);
    }

    /**
     * @return mixed | null
     */
    public function getQueueId()
    {
        if ($dto = $this->getQueue()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Locution\LocutionDto $locution
     *
     * @return static
     */
    public function setLocution(\Ivoz\Provider\Domain\Model\Locution\LocutionDto $locution = null)
    {
        $this->locution = $locution;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Locution\LocutionDto | null
     */
    public function getLocution()
    {
        return $this->locution;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setLocutionId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Locution\LocutionDto($id)
            : null;

        return $this->setLocution($value);
    }

    /**
     * @return mixed | null
     */
    public function getLocutionId()
    {
        if ($dto = $this->getLocution()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto $conferenceRoom
     *
     * @return static
     */
    public function setConferenceRoom(\Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto $conferenceRoom = null)
    {
        $this->conferenceRoom = $conferenceRoom;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto | null
     */
    public function getConferenceRoom()
    {
        return $this->conferenceRoom;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setConferenceRoomId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto($id)
            : null;

        return $this->setConferenceRoom($value);
    }

    /**
     * @return mixed | null
     */
    public function getConferenceRoomId()
    {
        if ($dto = $this->getConferenceRoom()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Extension\ExtensionDto $extension
     *
     * @return static
     */
    public function setExtension(\Ivoz\Provider\Domain\Model\Extension\ExtensionDto $extension = null)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Extension\ExtensionDto | null
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setExtensionId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Extension\ExtensionDto($id)
            : null;

        return $this->setExtension($value);
    }

    /**
     * @return mixed | null
     */
    public function getExtensionId()
    {
        if ($dto = $this->getExtension()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Country\CountryDto $numberCountry
     *
     * @return static
     */
    public function setNumberCountry(\Ivoz\Provider\Domain\Model\Country\CountryDto $numberCountry = null)
    {
        $this->numberCountry = $numberCountry;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Country\CountryDto | null
     */
    public function getNumberCountry()
    {
        return $this->numberCountry;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setNumberCountryId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Country\CountryDto($id)
            : null;

        return $this->setNumberCountry($value);
    }

    /**
     * @return mixed | null
     */
    public function getNumberCountryId()
    {
        if ($dto = $this->getNumberCountry()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param array $relMatchlists
     *
     * @return static
     */
    public function setRelMatchlists($relMatchlists = null)
    {
        $this->relMatchlists = $relMatchlists;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRelMatchlists()
    {
        return $this->relMatchlists;
    }

    /**
     * @param array $relSchedules
     *
     * @return static
     */
    public function setRelSchedules($relSchedules = null)
    {
        $this->relSchedules = $relSchedules;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRelSchedules()
    {
        return $this->relSchedules;
    }

    /**
     * @param array $relCalendars
     *
     * @return static
     */
    public function setRelCalendars($relCalendars = null)
    {
        $this->relCalendars = $relCalendars;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRelCalendars()
    {
        return $this->relCalendars;
    }

    /**
     * @param array $relRouteLocks
     *
     * @return static
     */
    public function setRelRouteLocks($relRouteLocks = null)
    {
        $this->relRouteLocks = $relRouteLocks;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRelRouteLocks()
    {
        return $this->relRouteLocks;
    }
}
