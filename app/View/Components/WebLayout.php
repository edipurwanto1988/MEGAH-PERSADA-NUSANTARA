<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class WebLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $metaDescription = null,
        public ?string $og_image = null,
        public ?string $twitter_image = null,
        public ?string $og_url = null,
        public string $og_type = 'website',
        public ?string $og_site_name = null,
        public string $twitter_card = 'summary_large_image',
        public ?string $twitter_title = null,
        public ?string $twitter_description = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.web');
    }
}