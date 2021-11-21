<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Site\Service\Sites;

final class AssetExtension extends AbstractExtension
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
            new TwigFunction('admin_asset', [$this, 'getAdminAssetsPath'], ['needs_environment' => false]),
        ];
    }

    public function getAssetsPath(string $path): string
    {
        if ('/' === $path[0]) {
            $path = mb_substr($path, 1);
        }

        if (\is_null($this->templateFolder)) {
            $this->templateFolder = $this->sites->getCurrentSite()->getTemplate()->getFolder();
        }

        return '/templates/' . $this->templateFolder . '/' . $path;
    }

    public function getAdminAssetsPath(string $path): string
    {
        if ('/' === $path[0]) {
            $path = mb_substr($path, 1);
        }

        return '/zentlix/main-bundle/admin/' . $path;
    }
}
