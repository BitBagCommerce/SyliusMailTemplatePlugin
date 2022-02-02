<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\Repository;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslation;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepository;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class EmailTemplateTranslationRepositorySpec extends ObjectBehavior
{
    public const ID_KEY = 'id';

    public const ID = 1;

    public const CLASS_NAME = 'className';

    public const LOCALE = 'en_US';

    public const EMAIL_TYPE = 'email_type';

    function it_is_initializable(RepositoryInterface $repository): void
    {
        $this->beConstructedWith($repository);
        $this->shouldHaveType(EmailTemplateTranslationRepository::class);
        $this->shouldHaveType(EmailTemplateTranslationRepositoryInterface::class);
    }

    function it_invokes_decorated_class_method_on_find(RepositoryInterface $repository): void
    {
        $repository->find(self::ID)->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->find(self::ID);
    }

    function it_invokes_decorated_class_method_on_find_all(RepositoryInterface $repository): void
    {
        $repository->findAll()->willReturn([]);
        $repository->findAll()->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->findAll();
    }

    function it_invokes_decorated_class_method_on_find_by(RepositoryInterface $repository): void
    {
        $repository->findBy([self::ID_KEY => self::ID], null, null, null)->willReturn([]);
        $repository->findBy([self::ID_KEY => self::ID], null, null, null)->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->findBy([self::ID_KEY => self::ID]);
    }

    function it_invokes_decorated_class_method_on_find_one_by(RepositoryInterface $repository): void
    {
        $repository->findOneBy([self::ID_KEY => self::ID])->willReturn(null);
        $repository->findOneBy([self::ID_KEY => self::ID])->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->findOneBy([self::ID_KEY => self::ID]);
    }

    function it_invokes_decorated_class_method_on_get_class_name(RepositoryInterface $repository): void
    {
        $repository->getClassName()->willReturn(self::CLASS_NAME);
        $repository->getClassName()->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->getClassName()->shouldReturn(self::CLASS_NAME);
    }

    function it_invokes_decorated_class_method_on_create_paginator(RepositoryInterface $repository): void
    {
        $repository->createPaginator([], [])->willReturn([]);
        $repository->createPaginator([], [])->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->createPaginator();
    }

    function it_invokes_decorated_class_method_on_add(RepositoryInterface $repository, ResourceInterface $resource): void
    {
        $repository->add($resource)->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->add($resource);
    }

    function it_invokes_decorated_class_method_on_remove(RepositoryInterface $repository, ResourceInterface $resource): void
    {
        $repository->remove($resource)->shouldBeCalled();

        $this->beConstructedWith($repository);
        $this->remove($resource);
    }

    function it_finds_one_by_locale_code_and_type(
        EntityRepository $repository,
        QueryBuilder $queryBuilder,
        AbstractQuery $query
    ): void {
        $repository->createQueryBuilder('tt', null)->willReturn($queryBuilder);

        $emailTemplateTranslation = new EmailTemplateTranslation();
        $query->getOneOrNullResult()->willReturn($emailTemplateTranslation);

        $queryBuilder->innerJoin('tt.translatable', 'templateEmail')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->where('tt.locale = :locale')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere('templateEmail.type = :type')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('locale', self::LOCALE)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('type', self::EMAIL_TYPE)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);

        $this->beConstructedWith($repository);
        $this->findOneByLocaleCodeAndType(self::LOCALE, self::EMAIL_TYPE)->shouldReturn($emailTemplateTranslation);
    }
}
