<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Material
 *
 * @ORM\Table(name="material")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaterialRepository")
 */
class Material
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
     * @var int
     *
     * @ORM\Column(name="mesh", type="integer")
     */
    private $mesh;

    /**
     * @var int
     *
     * @ORM\Column(name="numTextures", type="integer")
     */
    private $numTextures;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set mesh
     *
     * @param integer $mesh
     *
     * @return Material
     */
    public function setMesh($mesh)
    {
        $this->mesh = $mesh;

        return $this;
    }

    /**
     * Get mesh
     *
     * @return int
     */
    public function getMesh()
    {
        return $this->mesh;
    }

    /**
     * Set numTextures
     *
     * @param integer $numTextures
     *
     * @return Material
     */
    public function setNumTextures($numTextures)
    {
        $this->numTextures = $numTextures;

        return $this;
    }

    /**
     * Get numTextures
     *
     * @return int
     */
    public function getNumTextures()
    {
        return $this->numTextures;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Material
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

