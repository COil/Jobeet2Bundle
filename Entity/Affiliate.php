<?php

namespace COil\Jobeet2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * COil\Jobeet2Bundle\Entity\Affiliate
 *
 * @ORM\Table(name="affiliate")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Affiliate
{
    /**
     * @var bigint $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var Category
     *
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="affiliate")
     */
    private $category;

    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add category
     *
     * @param COil\Jobeet2Bundle\Entity\Category $category
     */
    public function addCategory(\COil\Jobeet2Bundle\Entity\Category $category)
    {
        $this->category[] = $category;
    }

    /**
     * Get category
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Standard string representation of the object.
     *
     * @return String
     */
    public function __toString()
    {
        return $this->getUrl();
    }

}