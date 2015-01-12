<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 14:41
 */

namespace AppBundle\Entity\Credit;

use AppBundle\Entity\General\PersonName;
use AppBundle\Entity\General\PostalAddress;
use AppBundle\Entity\IdInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LenderRepository::class)
 * @ORM\Table(name="credit_lender")
 */
class Lender implements IdInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var PersonName
     * @ORM\OneToOne(targetEntity=PersonName::class,cascade={"all"})
     */
    protected $name;

    /**
     * @var PostalAddress
     * @ORM\OneToOne(targetEntity=PostalAddress::class,cascade={"all"})
     */
    protected $address;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return PostalAddress
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param PostalAddress $address
     */
    public function setAddress(PostalAddress $address)
    {
        $this->address = $address;
    }

    /**
     * @return PersonName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(PersonName $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name->__toString().', '.(string) $this->address->__toString();
    }
}
