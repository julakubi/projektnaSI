<?php
/**
 * Atricle service.
 */

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ArticleService.
 */
class ArticleService
{
    /**
     * Article repository.
     *
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * Category service.
     *
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Tag service.
     *
     * @var TagService
     */
    private $tagService;

    /**
     * TaskService constructor.
     *
     * @param ArticleRepository  $articleRepository Articlerepository
     * @param PaginatorInterface $paginator         Paginator
     * @param CategoryService    $categoryService   Category service
     * @param TagService         $tagService        Tag service
     */
    public function __construct(ArticleRepository $articleRepository, PaginatorInterface $paginator, CategoryService $categoryService, TagService $tagService)
    {
        $this->articleRepository = $articleRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    /**
     * Create paginated list.
     *
     * @param int   $page    Page number
     * @param array $filters Filters array
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->articleRepository->QueryAll($filters),
            $page,
            ArticleRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save article.
     *
     * @param Article $article Article entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Article $article): void
    {
        $this->articleRepository->save($article);
    }

    /**
     * Delete article.
     *
     * @param Article $article Article entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Article $article): void
    {
        $this->articleRepository->delete($article);
    }
    /**
     * Prepare filters for the tasks list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category']) && is_numeric($filters['category'])) {
            $category = $this->categoryService->findOneById(
                $filters['category']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (isset($filters['tag']) && is_numeric($filters['tag'])) {
            $tag = $this->tagService->findOneById($filters['tag']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
