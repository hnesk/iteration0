<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 14:41
 */

namespace AppBundle\Entity\Credit;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="credit_change")
 */
class Change
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $periodStart;

    /**
     * @var integer
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $amount;

    /**
     * @var float
     * @ORM\Column(type="float",nullable=true)
     */
    protected $interest;

    /**
     * @param \DateTime $periodStart
     * @param int|null $amount
     * @param float|null $interest
     */
    public function __construct(\DateTime $periodStart = null, $amount = null, $interest = null) {
        $this->periodStart = $periodStart ?: new \DateTime();
        $this->amount = $amount;
        $this->interest = $interest;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param float $interest
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;
    }
}
