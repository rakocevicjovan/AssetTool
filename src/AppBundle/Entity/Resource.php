<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ResType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResourceRepository")
 */
class Resource
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Level", inversedBy="assets")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $level;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $resType;


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
     * Set path
     *
     * @param string $path
     *
     * @return Resource
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Resource
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

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }


    /**
     * Set resType
     *
     * @param int $resType
     *
     * @return Resource
     */
    public function setResType(ResType $resType)
    {
        $this->resType = $resType;

        return $this;
    }

    public function getResType()
    {
        return $this->resType;
    }

    public function __construct()
    {
        //$this->setResType();
    }
}

