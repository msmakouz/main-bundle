<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Site;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Application\Command\Site\UpdateCommand;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Domain\Template\Repository\TemplateRepository;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\FormType\AttributeType;
use Zentlix\MainBundle\UI\Http\Web\FormType\MetaType;
use Zentlix\MainBundle\UI\Http\Web\Type;

class Form extends AbstractForm
{
    protected EventDispatcherInterface $eventDispatcher;
    private TranslatorInterface $translator;
    private LocaleRepository $localeRepository;
    private SiteRepository $siteRepository;
    private TemplateRepository $templateRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TranslatorInterface $translator,
        LocaleRepository $localeRepository,
        SiteRepository $siteRepository,
        TemplateRepository $templateRepository
    ) {
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
            ->add('title', Type\TextType::class, [
                'label' => 'zentlix_main.title',
            ])
            ->add('url', Type\TextType::class, [
                'label' => 'zentlix_main.site.site_url',
                'prepend' => 'https://',
            ])
            ->add('locale', Type\ChoiceType::class, [
                'choices' => array_flip($this->localeRepository->assoc()),
                'label' => 'zentlix_main.site.locale',
            ])
            ->add('template', Type\ChoiceType::class, [
                'choices' => array_flip($this->templateRepository->assoc()),
                'label' => 'zentlix_main.template.template',
            ])
            ->add('meta', MetaType::class, ['inherit_data' => true, 'label' => false])
            ->add('sort', Type\IntegerType::class, [
                'label' => 'zentlix_main.sort',
                'data' => $command instanceof CreateCommand ?
                    $this->siteRepository->getMaxSort() + 1 : $command->sort,
                'constraints' => [
                    new GreaterThan(
                        ['value' => 0, 'message' => $this->translator->trans('zentlix_main.validation.greater_0')]
                    ),
                ],
            ]);

        $builder->add($main);

        $builder->add($builder->create('attributes', AttributeType::class, [
            'label' => 'zentlix_main.additional',
            'entity' => $command instanceof UpdateCommand ? $command->getEntity() : null,
            'code' => Site::getEntityCode(),
        ]));
    }
}
