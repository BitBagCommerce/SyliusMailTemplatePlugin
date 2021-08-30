<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
