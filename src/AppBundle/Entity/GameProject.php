<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * GameProject
 *
 * @ORM\Table(name="game_project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameProjectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GameProject
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="folderPath", type="string", length=500)
     */
    private $folderPath;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="level_count", type="integer")
     */
    private $levelCount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Level", mappedBy="project")
     */
    private $levels;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return GameProject
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set folderPath
     *
     * @param string $folderPath
     *
     * @return GameProject
     */
    public function setFolderPath($folderPath)
    {
        $this->folderPath = $folderPath;

        return $this;
    }

    /**
     * Get folderPath
     *
     * @return string
     */
    public function getFolderPath()
    {
        return $this->folderPath;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return GameProject
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return GameProject
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return GameProject
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Get level count
     *
     * @return int
     */
    public function getLevelCount()
    {
        return $this->levelCount;
    }

    /**
     * Set levelCount
     *
     * @param string $levelCount
     *
     * @return GameProject
     */
    public function setLevelCount($levelCount)
    {
        $this->levelCount = $levelCount;

        return $this;
    }

    public function addToLevelCount($delta)
    {
        $this->levelCount = $this->levelCount + $delta;

        return $this;
    }

    /**
     * @return Collection|Level[]
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }


    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->levels = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt($this->getCreatedAt());
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
        //$this->levelCount = $this->getLevels()->count();
    }


    /**
     * Gets triggered every time on read

     * @ORM\PreUpdate
     */
}

