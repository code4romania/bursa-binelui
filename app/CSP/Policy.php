<?php

declare(strict_types=1);

namespace App\CSP;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy as BasePolicy;

class Policy extends BasePolicy
{
    public function configure()
    {
        $this
            ->addGeneralDirectives()
            ->addDirectivesForGoogleMaps()
            ->addDirectivesForGoogleFonts()
            ->addDirectivesForGoogleAnalytics()
            ->addDirectivesForGoogleTagManager()
            ->addDirectivesForYouTube();
    }

    protected function addGeneralDirectives(): self
    {
        return $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
            ])
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
            ])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                Keyword::UNSAFE_EVAL,
                Keyword::UNSAFE_INLINE,
            ])
            ->addDirective(Directive::FORM_ACTION, [
                Keyword::SELF,
                'secure.euplatesc.ro',
            ])
            ->addDirective(Directive::IMG, [
                '*',
                'data:',
            ])
            ->addDirective(Directive::OBJECT, Keyword::SELF);
    }

    protected function addDirectivesForGoogleMaps(): self
    {
        return $this->addDirective(Directive::SCRIPT, [
            'maps.googleapis.com',
            'maps.gstatic.com',
        ]);
    }

    protected function addDirectivesForGoogleFonts(): self
    {
        return $this
            ->addDirective(Directive::FONT, 'fonts.gstatic.com')
            ->addDirective(Directive::SCRIPT, 'fonts.googleapis.com')
            ->addDirective(Directive::STYLE, 'fonts.googleapis.com');
    }

    protected function addDirectivesForGoogleAnalytics(): self
    {
        return $this->addDirective(Directive::SCRIPT, '*.google-analytics.com');
    }

    protected function addDirectivesForGoogleTagManager(): self
    {
        return $this->addDirective(Directive::SCRIPT, '*.googletagmanager.com');
    }

    protected function addDirectivesForYouTube(): self
    {
        return $this->addDirective(Directive::FRAME, '*.youtube.com');
    }
}
