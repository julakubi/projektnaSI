<?php
/**
 * Article fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ArticleFixtures.
 */
class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(
            50,
            'articles',
            function ($i) {
                $article = new Article();
                $article->setTitle($this->faker->sentence);
                $article->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $article->setModifiedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $article->setArticleText($this->faker->text(900));
                $article->setCategory($this->getRandomReference('categories'));
                $article->setAuthor($this->getRandomReference('admins'));
                $tags = $this->getRandomReferences(
                    'tags',
                    $this->faker->numberBetween(0, 5)
                );
                foreach ($tags as $tag) {
                    $article->addTag($tag);
                }

                return $article;
            }
        );
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class];
    }
}
