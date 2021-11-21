<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zentlix\MainBundle\UI\Http\Web\Type\TextType;

class MetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('meta_title', TextType::class, [
                'label' => 'zentlix_main.meta_title',
                'required' => false,
            ])
            ->add('meta_description', TextType::class, [
                'label' => 'zentlix_main.meta_description',
                'required' => false,
            ])
            ->add('meta_keywords', TextType::class, [
                'label' => 'zentlix_main.meta_keywords',
                'required' => false,
            ]);
    }
}
