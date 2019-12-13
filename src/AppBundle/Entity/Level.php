<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Level
 *
 * @ORM\Table(name="level")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LevelRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Level
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GameProject", inversedBy="levels")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Groups({"projGroup"})
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(name="json_def_path", type="string", length=255)
     */
    private $jsonDefPath;

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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Resource", mappedBy="level")
     */
    private $assets;


    /**
     * @var int
     *
     * @ORM\Column(name="resource_count", type="integer")
     */
    private $resourceCount;


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
     * @return Level
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
     * Set project
     *
     * @param integer $project
     *
     * @return Level
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return int
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set jsonDefPath
     *
     * @param string $jsonDefPath
     *
     * @return Level
     */
    public function setJsonDefPath($jsonDefPath)
    {
        $this->jsonDefPath = $jsonDefPath;

        return $this;
    }

    /**
     * Get jsonDefPath
     *
     * @return string
     */
    public function getJsonDefPath()
    {
        return $this->jsonDefPath;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Level
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
     * @return Level
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
     * Set description
     *
     * @param string $description
     *
     * @return Level
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
     * @return Collection|Resource[]
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }


    public function setAssets($assets)
    {
        $this->assets = $assets;
        return $this;
    }


    public function getResourceCount()
    {
        return $this->resourceCount;
    }

    public function setResourceCount($resCount)
    {
        $this->resourceCount = $resCount;
        return $this;
    }

    public function getFileName()
    {
        $arr = explode("\\", $this->getJsonDefPath());
        return end($arr);
    }

    public function __construct()
    {
        $assets = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}