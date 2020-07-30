<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Symfony\Component\Filesystem\Filesystem;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;

class JsonHandler implements CommandHandlerInterface
{
    private TranslatorInterface $translator;
    private LocaleRepository $localeRepository;
    private string $jsonLangFolder;

    public function __construct(TranslatorInterface $translator, LocaleRepository $localeRepository, string $projectDir)
    {
        $this->translator = $translator;
        $this->localeRepository = $localeRepository;
        $this->jsonLangFolder = $projectDir . '/public/zentlix/main-bundle/admin/dist/assets/i18n/';
    }

    public function __invoke(JsonCommand $command): void
    {
        $filesystem = new Filesystem();
        $locales = $this->localeRepository->findAll();

        foreach ($locales as $locale) {
            $text = $this->translator->getCatalogue($locale->getCode())->all();

            if(isset($text['messages']) && is_array($text['messages'])) {
                $filesystem->dumpFile($this->jsonLangFolder . $locale->getCode() . '.json', json_encode($text['messages']));
            }
        }
    }
}