<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

trait RepositoryDecoratorTrait
{
    private RepositoryInterface $decoratedRepository;

    public function find($id): ?object
    {
        return $this->decoratedRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->decoratedRepository->findAll();
    }

    /**
     * @return object[]
     */
    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        $limit = null,
        $offset = null
    ): array {
        return $this->decoratedRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria): ?object
    {
        return $this->decoratedRepository->findOneBy($criteria);
    }

    public function getClassName(): string
    {
        return $this->decoratedRepository->getClassName();
    }

    public function createPaginator(array $criteria = [], array $sorting = []): iterable
    {
        return $this->decoratedRepository->createPaginator($criteria, $sorting);
    }

    public function add(ResourceInterface $resource): void
    {
        $this->decoratedRepository->add($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->decoratedRepository->remove($resource);
    }

    private function createQueryBuilder(string $alias, ?string $indexBy = null): QueryBuilder
    {
        /** @phpstan-ignore-next-line */
        return $this->decoratedRepository->createQueryBuilder($alias, $indexBy);
    }
}
