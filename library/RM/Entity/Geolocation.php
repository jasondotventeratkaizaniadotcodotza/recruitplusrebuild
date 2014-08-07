<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="geolocations")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\GeolocationRepository")
 * @author Csabi
 */
class Geolocation
{

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /*
     * @ORM\OneToMany(targetEntity="JobListing",mappedBy="locationId")
     */
    private $jobListings;

    /**
     *
     * @var string $countryCode 
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $countryCode;

    /**
     *
     * @var string $postalCode 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $postalCode;

    /**
     *
     * @var string $placeName 
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $placeName;

    /**
     *
     * @var string $adminName1 
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adminName1;

    /**
     *
     * @var string $adminCode1 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $adminCode1;

    /**
     *
     * @var string $adminName2 
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adminName2;

    /**
     *
     * @var string $adminCode2 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $adminCode2;

    /**
     *
     * @var string $adminName3 
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adminName3;

    /**
     *
     * @var string $adminCode3
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $adminCode3;

    /**
     *
     * @var string $latitude 
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $latitude;

    /**
     *
     * @var string $longitude 
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $longitude;

    /**
     *
     * @var string $accuracy 
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $accuracy;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getPlaceName()
    {
        return $this->placeName;
    }

    public function setPlaceName($placeName)
    {
        $this->placeName = $placeName;
    }

    public function getAdminName1()
    {
        return $this->adminName1;
    }

    public function setAdminName1($adminName1)
    {
        $this->adminName1 = $adminName1;
    }

    public function getAdminCode1()
    {
        return $this->adminCode1;
    }

    public function setAdminCode1($adminCode1)
    {
        $this->adminCode1 = $adminCode1;
    }

    public function getAdminName2()
    {
        return $this->adminName2;
    }

    public function setAdminName2($adminName2)
    {
        $this->adminName2 = $adminName2;
    }

    public function getAdminCode2()
    {
        return $this->adminCode2;
    }

    public function setAdminCode2($adminCode2)
    {
        $this->adminCode2 = $adminCode2;
    }

    public function getAdminName3()
    {
        return $this->adminName3;
    }

    public function setAdminName3($adminName3)
    {
        $this->adminName3 = $adminName3;
    }

    public function getAdminCode3()
    {
        return $this->adminCode3;
    }

    public function setAdminCode3($adminCode3)
    {
        $this->adminCode3 = $adminCode3;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function getAccuracy()
    {
        return $this->accuracy;
    }

    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }

    public function getLocation()
    {
        return $this->postalCode . ', ' . $this->placeName;
    }
}