<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Repository;

use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

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
