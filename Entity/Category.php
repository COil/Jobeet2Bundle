<?php

namespace COil\Jobeet2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

use COil\Jobeet2Bundle\Lib\Jobeet as Jobeet;
use \DateTime as DateTime;

/**
 * COil\Jobeet2Bundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="COil\Jobeet2Bundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

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
     * @var ArrayCollection $job
     *
     * @ORM\OneToMany(targetEntity="Job", mappedBy="category")
     */
    private $jobs;

    /**
     * @var Affiliate
     *
     * @ORM\ManyToMany(targetEntity="Affiliate", inversedBy="category")
     * @ORM\JoinTable(name="category_affiliate",
     *   joinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     *   }
     * )
     */
    private $affiliate;

    /**
     * @var      Array   Represents the active jobs associated to the category
     * @internal         This property is not persisted
     */
    private $activeJobs;

    /**
     * @var      Integer Represents the count of active jobs of the category
     * @internal         This property is not persisted
     */
    private $countActiveJobs;

    /**
     * Main constructor.
     */
    public function __construct()
    {
        $this->affiliate  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs       = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activeJobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->countActiveJobs = 0;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set token automatically.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setSlugValue()
    {
        $this->slug = Jobeet::slugify($this->name);
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new DateTime();
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new DateTime();
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
     * Add affiliate
     *
     * @param COil\Jobeet2Bundle\Entity\Affiliate $affiliate
     */
    public function addAffiliate(\COil\Jobeet2Bundle\Entity\Affiliate $affiliate)
    {
        $this->affiliate[] = $affiliate;
    }

    /**
     * Get affiliate
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }

    /**
     * Add a Job to the category.
     *
     * @param COil\Jobeet2Bundle\Entity\Affiliate $affiliate
     */
    public function addJob(\COil\Jobeet2Bundle\Entity\Job $job)
    {
        $this->jobs[] = $job;
    }

    /**
     * Get Jobs.
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set the active jobs count.
     *
     * @param Integer
     */
    public function setCountActiveJobs($count)
    {
        $this->countActiveJobs = $count;
    }

    /**
     * Retrieve the active jobs count.
     *
     * @return Integer
     */
    public function countActiveJobs()
    {
        return $this->countActiveJobs;
    }

    /**
     * Set the active jobs.
     *
     * @param Integer
     */
    public function setActiveJobs($jobs)
    {
        $this->activeJobs = $jobs;
        $this->setCountActiveJobs(count($jobs));
    }

    /**
     * Retrieve the active jobs.
     *
     * @return Integer
     */
    public function getActiveJobs()
    {
        return $this->activeJobs;
    }

    /**
     * String.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}