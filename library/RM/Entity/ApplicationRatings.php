<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="application_ratings")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\ApplicationRatingsRepository")
 * @author Csabi
 */
class ApplicationRatings
{
    const USER_RATING_1 = 1;
    const USER_RATING_2 = 2;
    const USER_RATING_3 = 3;
    const USER_RATING_4 = 4;
    const USER_RATING_5 = 5;
    
    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userId;

    /**
     *
     * @var JobApplication
     * @ORM\ManyToOne(targetEntity="JobApplication", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jobApplicationId", referencedColumnName="id")
     * })
     */
    private $jobApplicationId;

    /**
     *
     * @var integer $userRating 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $userRating;

    /**
     *
     * @var string $userComment 
     * @ORM\Column(type="string", nullable=false)
     */
    private $userComment;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastModifiedDate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getJobApplicationId()
    {
        return $this->jobApplicationId;
    }

    public function setJobApplicationId($jobApplicationId)
    {
        $this->jobApplicationId = $jobApplicationId;
    }

    public function getUserRating()
    {
        return $this->userRating;
    }

    public function setUserRating($userRating)
    {
        if (!in_array($userRating, array(
                    self::USER_RATING_1,
                    self::USER_RATING_2,
                    self::USER_RATING_3,
                    self::USER_RATING_4,
                    self::USER_RATING_5,
                ))) {
            throw new \InvalidArgumentException("Invalid permission");
        }
        $this->userRating = $userRating;
    }

    public function getUserComment()
    {
        return $this->userComment;
    }

    public function setUserComment($userComment)
    {
        $this->userComment = $userComment;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

    public function setLastModifiedDate($lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;
    }

    public function __construct()
    {
        $dateTime = new \DateTime();
        $this->createdDate = $dateTime;
        $this->lastModifiedDate = $dateTime;
    }

}