<?php

namespace Struzik\EPPClient\Request\Domain;

use Struzik\EPPClient\Request\AbstractRequest;
use Struzik\EPPClient\Response\Domain\Renew as RenewResponse;
use Struzik\EPPClient\Node\Common\Renew as RenewNode;
use Struzik\EPPClient\Node\Common\Command;
use Struzik\EPPClient\Node\Common\TransactionId;
use Struzik\EPPClient\Node\Domain\Name;
use Struzik\EPPClient\Node\Domain\Renew as DomainRenewNode;
use Struzik\EPPClient\Node\Domain\Period;
use Struzik\EPPClient\Node\Domain\CurrentExpiryDate;

/**
 * Object representation of the request of domain renewal command.
 */
class Renew extends AbstractRequest
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var \DateTime
     */
    private $expiryDate;

    /**
     * @var int
     */
    private $period;

    /**
     * @var string
     */
    private $unit;

    /**
     * {@inheritdoc}
     */
    protected function handleParameters()
    {
        $epp = $this->getRoot();

        $command = new Command($this);
        $epp->append($command);

        $renew = new RenewNode($this);
        $command->append($renew);

        $domainRenew = new DomainRenewNode($this);
        $renew->append($domainRenew);

        $domainName = new Name($this, ['domain' => $this->domain]);
        $domainRenew->append($domainName);

        $expiryDate = new CurrentExpiryDate($this, ['expiry-date' => $this->expiryDate]);
        $domainRenew->append($expiryDate);

        if ($this->period !== null && $this->unit !== null) {
            $domainPeriod = new Period($this, ['period' => $this->period, 'unit' => $this->unit]);
            $domainRenew->append($domainPeriod);
        }

        $transaction = new TransactionId($this);
        $command->append($transaction);
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseClass()
    {
        return RenewResponse::class;
    }

    /**
     * Setting the name of the domain. REQUIRED.
     *
     * @param string $domain fully qualified name of the domain object
     *
     * @return self
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Getting the name of the domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Setting the date on which the current validity period ends. REQUIRED.
     *
     * @param \DateTime $expiryDate current expiry date
     *
     * @return self
     */
    public function setExpiryDate(\DateTime $expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Getting the date on which the current validity period ends.
     *
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Setting the number of units to be added to the registration period
     * of the domain object. OPTIONAL.
     *
     * @param int|null $period registration period
     *
     * @return self
     */
    public function setPeriod($period = null)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Getting the number of units to be added to the registration period
     * of the domain object.
     *
     * @return int|null
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Setting the unit of the period. OPTIONAL.
     *
     * @param string|null $unit constant of the unit
     *
     * @return self
     */
    public function setUnit($unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Getting the unit of the period.
     *
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
