<?php

namespace Beelab\SimplePageBundle\Entity;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute as AssertNoExistingRoute;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page.
 *
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields={"path"})
 */
class Page
{
    public static $templates = [
        'default' => 'default',
    ];

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(options={"default": "default"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[ \w\-]+$/i")
     */
    protected $template = 'default';

    /**
     * @var string|null
     *
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[^\/][\w\/\-]+$/i")
     * @Assert\Length(max=255)
     * @AssertNoExistingRoute()
     */
    protected $path;

    /**
     * @var string|null
     *
     * @ORM\Column()
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $title;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
