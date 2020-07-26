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

class AbstractForm extends AbstractType
{
    protected const SIMPLE_FORM = 'simple_form';
    protected const FLEX_2_FORM = 'flex_2_form';
    protected const TABS_FORM = 'tab_form';
}