<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Site;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Domain\Site\Repository\TemplateRepository;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

class Form extends AbstractForm
{
    protected EventDispatcherInterface $eventDispatcher;
    protected TranslatorInterface $translator;
    protected LocaleRepository $localeRepository;
    protected SiteRepository $siteRepository;
    protected TemplateRepository $templateRepository;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                TranslatorInterface $translator,
                                LocaleRepository $localeRepository,
                                SiteRepository $siteRepository,
                                TemplateRepository $templateRepository)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
        $this->localeRepository = $localeRepository;
        $this->siteRepository = $siteRepository;
        $this->templateRepository = $templateRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $command = $builder->getData();

        $main = $builder->create('main', Type\FormType::class, ['inherit_data' => true, 'label' => 'zentlix_main.main'])
            ->add('title', Type\TextType::class, ['label' => 'zentlix_main.title'])
            ->add('url', Type\TextType::class, [
                'label' =>'zentlix_main.site.site_url',
                'prepend' => 'https://'
            ])
            ->add('locale', Type\ChoiceType::class, [
                'choices'  => $this->localeRepository->assoc(),
                'label' => 'zentlix_main.site.locale'
            ])
            ->add('template', Type\ChoiceType::class, [
                'choices'  => $this->templateRepository->assoc(),
                'label' => 'zentlix_main.template'
            ])
            ->add('meta_title', Type\TextType::class, [
                'label' => 'zentlix_main.meta_title',
                'required' => false
            ])
            ->add('meta_description', Type\TextType::class, [
                'label' => 'zentlix_main.meta_description',
                'required' => false
            ])
            ->add('meta_keywords', Type\TextType::class, [
                'label' => 'zentlix_main.meta_keywords',
                'required' => false
            ])
            ->add('sort', Type\IntegerType::class, [
                'label' => 'zentlix_main.sort',
                'data' => $command instanceof CreateCommand ? $this->siteRepository->getMaxSort() + 1 : $command->sort,
                'constraints' => [
                    new GreaterThan(['value' => 0, 'message' => $this->translator->trans('zentlix_main.validation.greater_0')])
                ]
            ]);

        $builder->add($main);
    }
}