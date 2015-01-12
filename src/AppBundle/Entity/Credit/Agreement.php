<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 14:41
 */

namespace AppBundle\Entity\Credit;

use AppBundle\Entity\IdInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgreementRepository::class)
 * @ORM\Table(name="credit_agreement")
 */
class Agreement implements IdInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Lender
     * @ORM\ManyToOne(targetEntity=Lender::class)
     */
    protected $lender;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $interest;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $periodOfNotice;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $periodStart = null;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    protected $periodEnd = null;

    /**
     * @var Collection|Change[]
     * @ORM\ManyToMany(targetEntity=Change::class, cascade={"all"})
     * @ORM\JoinTable(
     *   name="credit_agreement_change",
     *   joinColumns={@ORM\JoinColumn(name="agreement_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="change_id", referencedColumnName="id", unique=true)}
     * )
     **/
    protected $changes = null;

    /**
     * @param Lender         $lender
     * @param int            $amount
     * @param float          $interest
     * @param int            $periodOfNotice
     * @param \DateTime|null $periodStart
     * @param \DateTime|null $periodEnd
     */
    public function __construct(Lender $lender = null, $amount = 500, $interest = 0.02, $periodOfNotice = 0, \DateTime $periodStart = null, \DateTime $periodEnd = null)
    {
        $this->lender = $lender;
        $this->amount = $amount;
        $this->interest = $interest;
        $this->periodOfNotice = $periodOfNotice;
        $this->periodStart = $periodStart ?: new \DateTime();
        $this->periodEnd = $periodEnd;
        $this->changes = new ArrayCollection();
    }

    public function __toString()
    {
        return number_format($this->amount, 2, ',', '.').'€ ,'.$this->lender->getName();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Lender
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * @param Lender $lender
     */
    public function setLender($lender)
    {
        $this->lender = $lender;
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

    /**
     * @return int
     */
    public function getPeriodOfNotice()
    {
        return $this->periodOfNotice;
    }

    /**
     * @param int $periodOfNotice
     */
    public function setPeriodOfNotice($periodOfNotice)
    {
        $this->periodOfNotice = $periodOfNotice;
    }

    /**
     * @return \DateTime|null
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * @param \DateTime|null $periodEnd
     */
    public function setPeriodEnd($periodEnd)
    {
        $this->periodEnd = $periodEnd;
    }

    /**
     * @return \DateTime|null
     */
    public function getPeriodStart()
    {
        return $this->periodStart;
    }

    /**
     * @param \DateTime|null $periodStart
     */
    public function setPeriodStart($periodStart)
    {
        $this->periodStart = $periodStart;
    }
}
