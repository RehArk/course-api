<?php

namespace App\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use App\EventListener\LocaleListener;

class LocaleListenerTest extends TestCase
{
    public function testSetLocaleFromAcceptLanguageHeader()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'fr-FR');

        $kernel = $this->createMock(HttpKernelInterface::class);
        $event = new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $listener = new LocaleListener('en');
        $listener->onKernelRequest($event);

        $this->assertEquals('fr', $request->getLocale());
    }

    public function testSetLocaleToDefaultWhenHeaderMissing()
    {
        $request = new Request();

        $kernel = $this->createMock(HttpKernelInterface::class);
        $event = new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $listener = new LocaleListener('en');
        $listener->onKernelRequest($event);

        $this->assertEquals('en', $request->getLocale());
    }

    public function testLocaleIsNormalizedToTwoLetters()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'es-MX');

        $kernel = $this->createMock(HttpKernelInterface::class);
        $event = new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $listener = new LocaleListener('en');
        $listener->onKernelRequest($event);

        $this->assertEquals('es', $request->getLocale());
    }
}
