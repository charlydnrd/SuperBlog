<?php

namespace App\Entity;

use App\Repository\BlogMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogMessageRepository::class)
 */
class BlogMessage
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
    private $blog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlog(): ?string
    {
        return $this->blog;
    }

    public function setBlog(string $blog): self
    {
        $this->blog = $blog;

        return $this;
    }
}
