<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 14:52
 */

namespace AppBundle\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="postaladdress")
 */
class PostalAddress
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The address country
     * @var string
     * @ORM\Column(type="string", length=2);
     */
    protected $country;

    /**
     * The address locality
     * @var string
     * @ORM\Column(type="string");
     */
    protected $locality;

    /**
     * The address region
     * @var string
     * @ORM\Column(type="string", nullable=true);
     */
    protected $region;

    /**
     * The post office box number
     * @var string
     * @ORM\Column(type="string", nullable=true);
     */
    protected $postOfficeBoxNumber;

    /**
     * The postal code
     * @var string
     * @ORM\Column(type="string");
     */
    protected $postalCode;

    /**
     * The street address
     * @var string
     * @ORM\Column(type="string");
     */
    protected $streetAddress;

    public function __construct(
        $streetAddress = '',
        $postalCode = '',
        $locality = '',
        $region = 'NRW',
        $country = 'DE',
        $postOfficeBoxNumber = ''
    ) {
        $this->streetAddress = $streetAddress;
        $this->postalCode = $postalCode;
        $this->locality = $locality;
        $this->region = $region;
        $this->country = $country;
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;
    }

    /**
     * Get the Postal address's country
     *
     * @return string The Postal address's country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets this Postal address's country
     *
     * @param  string $addressCountry The Postal address's country
     * @return void
     */
    public function setCountry($addressCountry)
    {
        $this->country = $addressCountry;
    }

    /**
     * Get the Postal address's address locality
     *
     * @return string The Postal address's address locality
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets this Postal address's locality
     *
     * @param  string $addressLocality The Postal address's locality
     * @return void
     */
    public function setLocality($addressLocality)
    {
        $this->locality = $addressLocality;
    }

    /**
     * Get the Postal address's address region
     *
     * @return string The Postal address's address region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Sets this Postal address's region
     *
     * @param  string $addressRegion The Postal address's region
     * @return void
     */
    public function setRegion($addressRegion)
    {
        $this->region = $addressRegion;
    }

    /**
     * Get the Postal address's post office box number
     *
     * @return string The Postal address's post office box number
     */
    public function getPostOfficeBoxNumber()
    {
        return $this->postOfficeBoxNumber;
    }

    /**
     * Sets this Postal address's post office box number
     *
     * @param  string $postOfficeBoxNumber The Postal address's post office box number
     * @return void
     */
    public function setPostOfficeBoxNumber($postOfficeBoxNumber)
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;
    }

    /**
     * Get the Postal address's postal code
     *
     * @return string The Postal address's postal code
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets this Postal address's postal code
     *
     * @param  string $postalCode The Postal address's postal code
     * @return void
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Get the Postal address's street address
     *
     * @return string The Postal address's street address
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Sets this Postal address's street address
     *
     * @param  string $streetAddress The Postal address's street address
     * @return void
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->streetAddress . ', ' . $this->postalCode . ' ' . $this->locality.', '.$this->country;
    }


}