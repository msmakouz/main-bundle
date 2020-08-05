<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Locale\Specification\ExistLocaleSpecification;
use Zentlix\MainBundle\Domain\Site\Event\Site\BeforeUpdate;
use Zentlix\MainBundle\Domain\Site\Event\Site\AfterUpdate;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Domain\Site\Repository\TemplateRepository;
use Zentlix\MainBundle\Domain\Site\Specification\UniqueUrlSpecification;
use Zentlix\MainBundle\Domain\Site\Specification\ExistTemplateSpecification;
use Zentlix\MainBundle\Domain\Site\Specification\ExistTemplateFolderSpecification;

class UpdateHandler implements CommandHandlerInterface
{
    private UniqueUrlSpecification $uniqueUrlSpecification;
    private ExistLocaleSpecification $existLocaleSpecification;
    private ExistTemplateSpecification $existTemplateSpecification;
    private ExistTemplateFolderSpecification $existTemplateFolderSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private LocaleRepository $localeRepository;
    private TemplateRepository $templateRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                UniqueUrlSpecification $uniqueUrlSpecification,
                                ExistLocaleSpecification $existLocaleSpecification,
                                ExistTemplateSpecification $existTemplateSpecification,
                                ExistTemplateFolderSpecification $existTemplateFolderSpecification,
                                LocaleRepository $localeRepository,
                                TemplateRepository $templateRepository)
    {
        $this->uniqueUrlSpecification = $uniqueUrlSpecification;
        $this->existLocaleSpecification = $existLocaleSpecification;
        $this->existTemplateSpecification = $existTemplateSpecification;
        $this->existTemplateFolderSpecification = $existTemplateFolderSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->localeRepository = $localeRepository;
        $this->templateRepository = $templateRepository;
    }

    public function __invoke(UpdateCommand $command): void
    {
        $site = $command->getEntity();

        if(!$site->isUrlEqual($command->url)) {
            $this->uniqueUrlSpecification->isUnique($command->url);
        }

        $this->existLocaleSpecification->isExist($command->locale);
        $this->existTemplateSpecification->isExist($command->template);
        $command->template = $this->templateRepository->get($command->template);
        $command->locale = $this->localeRepository->get($command->locale);
        $this->existTemplateFolderSpecification->isExist($command->template->getFolder());

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $site->update($command);

        $this->entityManager->flush();

        Sites::clearCache();

        $this->eventDispatcher->dispatch(new AfterUpdate($site, $command));
    }
}