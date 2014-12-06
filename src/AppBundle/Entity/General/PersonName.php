<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 14:52
 */

namespace AppBundle\Entity\General;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="personname")
 */
class PersonName
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Bitte gib einen Vornamen an")
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Bitte gib einen Nachnamen an")
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices={"m","f"})
     */
    protected $gender;

    public function __construct($firstName = '', $lastName = '', $gender = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstName.' '.$this->lastName;
    }


}