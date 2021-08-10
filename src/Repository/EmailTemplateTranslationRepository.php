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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class EmailTemplateTranslationRepository extends EntityRepository implements EmailTemplateTranslationRepositoryInterface
{
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
