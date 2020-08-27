<?php

namespace Ivoz\Provider\Domain\Model\Recording;

class RecordingDto extends RecordingDtoAbstract
{
    private $recordedFile;

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'callid' => 'callid',
                'calldate' => 'calldate',
                'type' => 'type',
                'duration' => 'duration',
                'caller' => 'caller',
                'callee' => 'callee',
                'id' => 'id'
            ];
        }

        $response = parent::getPropertyMap(...func_get_args());

        if ($role === 'ROLE_COMPANY_ADMIN') {
            unset($response['companyId']);
        }

        return $response;
    }

    public function denormalize(array $data, string $context, string $role = '')
    {
        $contextProperties = self::getPropertyMap($context, $role);
        if ($role === 'ROLE_COMPANY_ADMIN') {
            $contextProperties['companyId'] = 'company';
        }

        $this->setByContext(
            $contextProperties,
            $data
        );
    }

    public function getFileObjects()
    {
        return [
            'recordedFile'
        ];
    }

    /**
     * @return self
     */
    public function setRecordedFilePath(string $recordedFilePath = null)
    {
        $this->recordedFile = $recordedFilePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecordedFilePath()
    {
        return $this->recordedFile;
    }
}
