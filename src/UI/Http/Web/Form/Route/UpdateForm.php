<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Route;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zentlix\MainBundle\Application\Command\Route\UpdateCommand;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\UI\Http\Web\FormType\RouteType;
use Zentlix\MainBundle\UI\Http\Web\Type;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;

class UpdateForm extends AbstractForm
{
    private SiteRepository $siteRepository;

    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('info', Type\NoticeType::class, ['data' => 'zentlix_main.route.info'])
            ->add('site', Type\ChoiceType::class, [
                'choices'  => $this->siteRepository->assoc(),
                'label' => 'zentlix_main.site.site',
                'required' => false,
                'update' => true
            ])
            ->add('routes', Type\CollectionType::class, [
                'entry_type' => RouteType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'     => UpdateCommand::class,
            'label'          => 'zentlix_main.route.routes',
            'form'           => self::SIMPLE_FORM,
            'disable_delete' => true
        ]);
    }
}