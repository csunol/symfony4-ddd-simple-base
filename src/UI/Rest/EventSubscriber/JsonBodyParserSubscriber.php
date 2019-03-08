<?php

namespace App\UI\Rest\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class JsonBodyParserSubscriber
 * @package App\Infrastructure\UI\EventSubscriber
 */
class JsonBodyParserSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$this->isJsonRequest($request)) {
            return;
        }
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }
        if (!$this->transformJsonBody($request)) {
            $response = Response::create('Unable to parse json request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);
        if (JSON_ERROR_NONE !== json_last_error() || is_string($data)) {
            return false;
        }
        if (null === $data) {
            return true;
        }
        $request->request->replace($data);
        return true;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
