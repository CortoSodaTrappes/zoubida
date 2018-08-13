<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonsRepository")
 */
class Lessons
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $lesson;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idcategories;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLesson(): ?string
    {
        return $this->lesson;
    }

    public function setLesson(string $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
  
    public function getIdcategories(): ?Categories
    {
        return $this->idcategories;
    }

    public function setIdcategories(?Categories $idcategories): self
    {
        $this->idcategories = $idcategories;
        return $this;
    }
}
