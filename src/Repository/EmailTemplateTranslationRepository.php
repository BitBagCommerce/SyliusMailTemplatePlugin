<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Repository;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

final class EmailTemplateTranslationRepository implements EmailTemplateTranslationRepositoryInterface
{
    use RepositoryDecoratorTrait;

    public function __construct(RepositoryInterface $decoratedRepository)
    {
        $this->decoratedRepository = $decoratedRepository;
    }

    public function findOneByLocaleCodeAndType(string $localeCode, string $type): ?EmailTemplateTranslationInterface
    {
        return $this->createQueryBuilder('tt')
            ->innerJoin('tt.translatable', 'templateEmail')
            ->where('tt.locale = :locale')
            ->andWhere('templateEmail.type = :type')
            ->setParameter('locale', $localeCode)
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
