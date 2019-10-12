<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $chars_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $paragraphs_count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCharsCount(): ?int
    {
        return $this->chars_count;
    }

    public function setCharsCount(int $chars_count): self
    {
        $this->chars_count = $chars_count;

        return $this;
    }

    public function getParagraphsCount(): ?int
    {
        return $this->paragraphs_count;
    }

    public function setParagraphsCount(int $paragraphs_count): self
    {
        $this->paragraphs_count = $paragraphs_count;

        return $this;
    }
}
