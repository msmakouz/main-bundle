<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Widget;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use function is_null;

class Asset extends AbstractExtension
{
    private Sites $sites;
    private ?string $templateFolder = null;

    public function __construct(Sites $sites)
    {
        $this->sites = $sites;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('template_asset', [$this, 'getAssetsPath'], ['needs_environment' => false]),
            new TwigFunction('admin_asset', [$this, 'getAdminAssetsPath'], ['needs_environment' => false])
        ];
    }

    public function getAssetsPath(string $path)
    {
        if($path[0] === '/') {
            $path = substr($path, 1);
        }

        if(is_null($this->templateFolder)) {
            $this->templateFolder = $this->sites->getCurrentSite()->getTemplate()->getFolder();
        }

        return '/templates/' . $this->templateFolder . '/' . $path;
    }

    public function getAdminAssetsPath(string $path)
    {
        if($path[0] === '/') {
            $path = substr($path, 1);
        }

        return '/zentlix/main-bundle/admin/' . $path;
    }
}