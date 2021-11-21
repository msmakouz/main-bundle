<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Read;

use Zentlix\MainBundle\Domain\Locale\Read\LocaleView;
use Zentlix\MainBundle\Domain\Template\Read\TemplateView;

class SiteView
{
    public string $id;
    public string $title;
    public string $url;
    public ?string $meta_title;
    public ?string $meta_description;
    public ?string $meta_keywords;
    public LocaleView $locale;
    public TemplateView $template;
    public int $sort;

    public function __construct(
        $id,
        $title,
        $url,
        $sort,
        $meta,
        $locale_id,
        $locale_code,
        $locale_title,
        $locale_icon,
        $locale_sort,
        $template_id,
        $template_title,
        $template_folder,
        $template_sort
    ) {
        $this->id = (string) $id;
        $this->title = (string) $title;
        $this->url = (string) $url;
        $this->meta_title = $meta['title'] ?? null;
        $this->meta_description = $meta['description'] ?? null;
        $this->meta_keywords = $meta['keywords'] ?? null;
        $this->locale = new LocaleView($locale_id, $locale_code, $locale_title, $locale_icon, $locale_sort);
        $this->template = new TemplateView($template_id, $template_title, $template_folder, $template_sort);
        $this->sort = (int) $sort;
    }
}
