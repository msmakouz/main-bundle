<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zentlix\MainBundle\UI\Http\Web\Type\TextType;

class MetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('meta_title', TextType::class, [
                'label'    => 'zentlix_main.meta_title',
                'required' => false
            ])
            ->add('meta_description', TextType::class, [
                'label'    => 'zentlix_main.meta_description',
                'required' => false
            ])
            ->add('meta_keywords', TextType::class, [
                'label'    => 'zentlix_main.meta_keywords',
                'required' => false
            ]);
    }
}