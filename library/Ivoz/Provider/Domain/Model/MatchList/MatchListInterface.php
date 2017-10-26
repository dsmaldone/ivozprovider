<?php

namespace Ivoz\Provider\Domain\Model\MatchList;

use Ivoz\Core\Domain\Model\EntityInterface;
use Doctrine\Common\Collections\Collection;

interface MatchListInterface extends EntityInterface
{
    /**
     * Check if the given number matches the list rules
     *
     * @param string $number in E164 form
     * @return true if number matches, false otherwise
     */
    public function numberMatches($number);

    /**
     * @return array
     */
    public function getChangeSet();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set company
     *
     * @param \Ivoz\Provider\Domain\Model\Company\CompanyInterface $company
     *
     * @return self
     */
    public function setCompany(\Ivoz\Provider\Domain\Model\Company\CompanyInterface $company);

    /**
     * Get company
     *
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyInterface
     */
    public function getCompany();

    /**
     * Add pattern
     *
     * @param \Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPatternInterface $pattern
     *
     * @return MatchListTrait
     */
    public function addPattern(\Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPatternInterface $pattern);

    /**
     * Remove pattern
     *
     * @param \Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPatternInterface $pattern
     */
    public function removePattern(\Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPatternInterface $pattern);

    /**
     * Replace patterns
     *
     * @param \Ivoz\Provider\Domain\Model\MatchListPattern\MatchListPatternInterface[] $patterns
     * @return self
     */
    public function replacePatterns(Collection $patterns);

    /**
     * Get patterns
     *
     * @return array
     */
    public function getPatterns(\Doctrine\Common\Collections\Criteria $criteria = null);

}
