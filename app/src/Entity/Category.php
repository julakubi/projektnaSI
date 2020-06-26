<?php
/**
 * Category entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"categoryName"})
 */
class Category
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
     * categoryName.
     *
     * @var string
     *
     * @ORM\Column(type="string",length=45,)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $categoryName;

    /**
     * Article.
     *
     * @var ArrayCollection|Article[] Article
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Article",
     *     mappedBy="category",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private $articles;

    /**
     * Category constructor.
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
     * Getter for categoryName.
     *
     * @return string|null categoryName
     */
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    /**
     * Setter for categoryName.
     *
     * @param string $categoryName Category
     */
    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    /**
     * Getter for Article.
     *
     * @return Collection|Article[] Article collection
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * Add comment to collection.
     *
     * @param Article $article Article collection
     */
    public function addArticle(Article $article): void
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }
    }

    /**
     * Remove article for collection.
     *
     * @param Article $article Article collection
     */
    public function removeArticle(Article $article): void
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }
    }
}
