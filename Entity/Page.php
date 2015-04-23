<?php

namespace Beelab\SimplePageBundle\Entity;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute as AssertNoExistingRoute;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields={"path"})
 */
class Page
{
    public static $templates = array(
        'default' => 'default',
    );

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(options={"default": "default"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[ \w\-]+$/i")
     */
    protected $template = 'default';

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[^\/][\w\/\-]+$/i")
     * @Assert\Length(max=255)
     * @AssertNoExistingRoute()
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column()
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

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
     * Set template
     *
     * @param  string $template
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set path
     *
     * @param  string $path
     * @return Page
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
     * Set title
     *
     * @param  string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param  string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
