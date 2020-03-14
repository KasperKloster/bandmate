<?php
namespace App\Http\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class SpatieCspExtended extends Basic
{
    public function configure()
    {
        parent::configure();
        // $this->addDirective(Directive::SCRIPT, 'www.google.com');

        $this->addDirective(Directive::FONT, 'https://fonts.gstatic.com/');
        $this->addDirective(Directive::FONT, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/fonts/');
        $this->addDirective(Directive::FONT, 'https://kit-free.fontawesome.com/');

        $this->addDirective(Directive::STYLE, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/');
        $this->addDirective(Directive::STYLE, 'https://fonts.googleapis.com/');
        $this->addDirective(Directive::STYLE, 'https://kit-free.fontawesome.com/');

        $this->addDirective(Directive::SCRIPT, 'https://code.jquery.com/jquery-3.4.1.min.js');
        $this->addDirective(Directive::SCRIPT, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/');
        $this->addDirective(Directive::SCRIPT, 'https://www.googletagmanager.com/');
        $this->addDirective(Directive::SCRIPT, 'https://kit.fontawesome.com/');

        $this->addDirective(Directive::IMG, 'https://s1.ticketm.net/');
        $this->addDirective(Directive::IMG, 'https://media.ticketmaster.eu/');

        // $this->addDirective(Directive::STYLE, 'self unsafe-inline');

    }
}
