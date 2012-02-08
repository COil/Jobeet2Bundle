<?php

namespace COil\Jobeet2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use COil\Jobeet2Bundle\Lib\Jobeet as Jobeet;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * COil\Jobeet2Bundle\Entity\Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="COil\Jobeet2Bundle\Repository\JobRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Job
{
    static public $types = array(
        'full-time' => 'Full time',
        'part-time' => 'Part time',
        'freelance' => 'Freelance',
    );

    /**
     * @var bigint $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string $company
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $company;

    /**
     * @var string $logo
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     * @Assert\File(
     *      maxSize="1M",
     *      mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}*
     * )
     */
    private $logo;

    /**
     * @var Symfony\Component\HttpFoundation\File\UploadedFile  The Uploaded file object for the logo
     */
    private $logoUploadedFile;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string $position
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=false)
     */
    private $position;

    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $location;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var text $howToApply
     *
     * @ORM\Column(name="how_to_apply", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $howToApply;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var $isPublic
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    private $isPublic = true;

    /**
     * @var boolean $isActivated
     *
     * @ORM\Column(name="is_activated", type="boolean", nullable=true)
     */
    private $isActivated = false;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @var DateTime $expiresAt
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=false)
     */
    private $expiresAt;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var COil\Jobeet2Bundle\Entity\Category $category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Get id
     *
     * @return bigint
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * List all allowed types.
     *
     * @return type
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Translated type name.
     */
    public function getTypeName()
    {
        $types = self::getTypes();

        return $this->getType() ? $types[$this->getType()] : '';
    }

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set howToApply
     *
     * @param text $howToApply
     */
    public function setHowToApply($howToApply)
    {
        $this->howToApply = $howToApply;
    }

    /**
     * Get howToApply
     *
     * @return text
     */
    public function getHowToApply()
    {
        return $this->howToApply;
    }

    /**
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Set token automatically.
     *
     * @ORM\PrePersist
     * @param string $token
     */
    public function setTokenValue()
    {
        $this->token = sha1($this->getEmail(). rand(11111, 99999));
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set isActivated
     *
     * @param boolean $isActivated
     */
    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;
    }

    /**
     * Get isActivated
     *
     * @return boolean
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set expiresAt
     *
     * @param DateTime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setExpiresAtValue()
    {
        $expiresAt = new \DateTime($this->getCreatedAt()->format('Y-m-d H:i:s'));
        $expiresAt->add(new \DateInterval('P30D'));
        $this->expiresAt = $expiresAt;
    }

    /**
     * Get expiresAt
     *
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set category
     *
     * @param COil\Jobeet2Bundle\Entity\Category $category
     */
    public function setCategory(\COil\Jobeet2Bundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return COil\Jobeet2Bundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Returne the slug of the company.
     *
     * @return String
     */
    public function getCompanySlug()
    {
        return Jobeet::slugify($this->getCompany());
    }

    /**
     * Returns the slug of the position.
     *
     * @return String
     */
    public function getPositionSlug()
    {
        return Jobeet::slugify($this->getPosition());
    }

    /**
     * Returne the slug of the location.
     *
     * @return String
     */
    public function getLocationSlug()
    {
        return Jobeet::slugify($this->getLocation());
    }

    /**
     * Tells if job is already expired.
     *
     * @return Boolean
     */
    public function isExpired()
    {
        return $this->getDaysBeforeExpires() < 0;
    }

    /**
     * Tells if the job is about to expire.
     *
     * @return Boolean
     */
    public function expiresSoon()
    {
        return $this->getDaysBeforeExpires() < 5;
    }

    /**
     * Return
     * @return Integer
     */
    public function getDaysBeforeExpires()
    {
        return ceil(($this->getExpiresAt()->format('U') - time()) / 86400);
    }

    /**
     * Get the required parameters for the route "job_show"
     *
     * @return type
     */
    public function getShowRouteParameters()
    {
        return array(
            'id'            => $this->getId(),
            'company_slug'  => $this->getCompanySlug(),
            'location_slug' => $this->getLocationSlug(),
            'position_slug' => $this->getPositionSlug()
        );
    }

    /**
     * Upload related functions.
     *
     * @see http://symfony.com/doc/current/cookbook/doctrine/file_uploads.html
     * @return String
     */
    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir(). '/'. $this->logo;
    }

    /**
     * Get public webpath for object.
     *
     * @return String
     */
    public function getWebPath()
    {
        return null === $this->logo ? null : $this->getUploadDir(). '/'. $this->logo;
    }

    /**
     * Get physicali main upload dir for object type.
     *
     * @return String
     */
    protected function getUploadRootDir()
    {
        return __DIR__. '/../../../../web/'. $this->getUploadDir();
    }

    /**
     * Get relative upload dir for object.
     *
     * @return String
     */
    protected function getUploadDir()
    {
        return 'uploads/jobs';
    }

   /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Make a string test for fixtures loading
        if (null !== $this->logo && !is_string($this->logo)) {

            // Save the uploaded object so we can use it in the Upload function
            $this->logoUploadedFile = $this->logo;

            // Generate a unique logo file name but the correct extension
            $this->logo = uniqid('job_', true). '.'. $this->logo->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->logoUploadedFile) {
            return;
        }

        $this->logoUploadedFile->move($this->getUploadRootDir(), $this->logo);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if (!empty($file) && is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Flag the job as published.
     */
    public function publish()
    {
        $this->setIsActivated(true);
    }

    /**
     * Extends the Job validity and visibility.
     *
     * @return Boolean
     */
    public function extend($activeDays)
    {
        if (!$this->expiresSoon())
        {
            return false;
        }

        $this->setExpiresAt(new \DateTime(date('Y-m-d', time() + 86400 * $activeDays)));

        return true;
    }

    /**
     * Compute the etag in order to cache content related to the object.
     *
     * @return String
     */
    public function computeETag()
    {
        return md5('job_'. $this->id);
    }

    /**
     * Standard string representation of object.
     *
     * @return String
     */
    public function __toString()
    {
        return sprintf('%s at %s (%s)', $this->getPosition(), $this->getCompany(), $this->getLocation());
    }
}