<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    private string $defaultLocale;

    public function __construct(string $defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $locale = $request->headers->get('Accept-Language', $this->defaultLocale);
        $normalizedLocale = substr($locale, 0, 2);

        $request->setLocale($normalizedLocale);
    }
}
