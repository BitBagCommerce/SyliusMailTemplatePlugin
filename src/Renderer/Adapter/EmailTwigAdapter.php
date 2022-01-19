<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Renderer\Adapter;

use Sylius\Component\Mailer\Event\EmailRenderEvent;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AbstractAdapter;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\SyliusMailerEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;
use Twig\Extension\StringLoaderExtension;
use Twig\Loader\ArrayLoader;

final class EmailTwigAdapter extends AbstractAdapter
{
    protected Environment $twig;

    protected $dispatcher;

    public function __construct(Environment $twig, ?EventDispatcherInterface $dispatcher = null)
    {
        $this->twig = $twig;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function render(EmailInterface $email, array $data = []): RenderedEmail
    {
        $renderedEmail = $this->getRenderedEmail($email, $data);

        $event = new EmailRenderEvent($renderedEmail);

        if ($this->dispatcher !== null) {
            /** @var EmailRenderEvent $event */
            $event = $this->dispatcher->dispatch($event, SyliusMailerEvents::EMAIL_PRE_RENDER);
        }

        return $event->getRenderedEmail();
    }

    private function getRenderedEmail(EmailInterface $email, array $data): RenderedEmail
    {
        if (null !== $email->getTemplate()) {
            return $this->provideEmailWithTemplate($email, $data);
        }

        return $this->provideEmailWithoutTemplate($email, $data);
    }

    /**
     * @psalm-suppress InternalMethod
     */
    private function provideEmailWithTemplate(EmailInterface $email, array $data): RenderedEmail
    {
        if (!$this->twig->hasExtension(StringLoaderExtension::class)) {
            $this->twig->addExtension(new StringLoaderExtension());
        }

        $data = $this->twig->mergeGlobals($data);

        if (!$data['template']) {
            $template = $this->twig->loadTemplate((string) $email->getTemplate());
        } else {
            $template = $this->twig->loadTemplate("@BitBagSyliusMailTemplatePlugin/Admin/Email/customTemplate.html.twig");
        }

        $subject = $template->renderBlock('subject', $data);
        $body = $template->renderBlock('body', $data);

        return new RenderedEmail($subject, $body);
    }

    private function provideEmailWithoutTemplate(EmailInterface $email, array $data): RenderedEmail
    {
        $twig = new Environment(new ArrayLoader([]));

        $subjectTemplate = $twig->createTemplate((string) $email->getSubject());
        $bodyTemplate = $twig->createTemplate((string) $email->getContent());

        $subject = $subjectTemplate->render($data);
        $body = $bodyTemplate->render($data);

        return new RenderedEmail($subject, $body);
    }
}
