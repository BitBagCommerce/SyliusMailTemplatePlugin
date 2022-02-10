<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

final class EmailTemplateRepository implements EmailTemplateRepositoryInterface
{
    use RepositoryDecoratorTrait;

    public function __construct(RepositoryInterface $decoratedRepository)
    {
        $this->decoratedRepository = $decoratedRepository;
    }

    public function getAllTypes(): array
    {
        return $this->createQueryBuilder('et')
                    ->select('et.type')
                    ->getQuery()
                    ->getResult()
            ;
    }
}
