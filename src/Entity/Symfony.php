<?php

namespace App\Entity;

use App\Repository\SymfonyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymfonyRepository::class)
 */
class Symfony
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ren;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRen(): ?string
    {
        return $this->ren;
    }

    public function setRen(string $ren): self
    {
        $this->ren = $ren;

        return $this;
    }
}
