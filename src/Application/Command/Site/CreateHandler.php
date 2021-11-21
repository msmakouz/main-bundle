<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Locale\Specification\ExistLocaleSpecification;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Site\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Domain\Site\Specification\UniqueUrlSpecification;
use Zentlix\MainBundle\Domain\Template\Repository\TemplateRepository;
use Zentlix\MainBundle\Domain\Template\Specification\ExistFolderSpecification;
use Zentlix\MainBundle\Domain\Template\Specification\ExistTemplateSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private UniqueUrlSpecification $uniqueUrlSpecification,
        private ExistLocaleSpecification $existLocaleSpecification,
        private ExistTemplateSpecification $existTemplateSpecification,
        private ExistFolderSpecification $existFolderSpecification,
        private LocaleRepository $localeRepository,
        private TemplateRepository $templateRepository,
        private Attributes $attributes
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->uniqueUrlSpecification->isUnique($command->url);
        $this->existLocaleSpecification->isExist($command->locale);
        $this->existTemplateSpecification->isExist($command->template);
        $command->template = $this->templateRepository->get($command->template);
        $command->locale = $this->localeRepository->get($command->locale);
        $this->existFolderSpecification->isExist($command->template->getFolder());

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $site = new Site($command);

        $this->entityManager->persist($site);
        $this->entityManager->flush();

        $this->attributes->saveValues($site, $command->attributes);

        Sites::clearCache();

        $this->eventDispatcher->dispatch(new AfterCreate($site, $command));
    }
}
