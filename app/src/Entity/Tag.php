<?php
/**
 * Tag entity.
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"tagName"})
 */
class Tag
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * TagName.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *      length=45
     *     )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $tagName;

    /**
     * Articles.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Article[] Article
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="tags")
     *
     * @Assert\Type(type="Doctrine\Common\Collection\ArrayCollection")
     */
    private $articles;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for TagName.
     *
     * @return string|null TagName
     */
    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    /**
     * Setter for TagName.
     *
     * @param string $tagName TagName
     */
    public function setTagName(string $tagName): void
    {
        $this->tagName = $tagName;
    }

    /**
     * Getter for Article.
     *
     * @return Collection|Article[] Articles collection
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * Add article to collection.
     *
     * @param Article $article Article entity
     */
    public function addArticle(Article $article): void
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addTag($this);
        }
    }

    /**
     * Remove article form collection.
     *
     * @param Article $article Article entity
     */
    public function removeArticle(Article $article): void
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeTag($this);
        }
    }
}
