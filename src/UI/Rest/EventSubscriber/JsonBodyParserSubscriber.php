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

        if (empty($content) || is_null($content)) {
            return;
        }

        $data = $this->parseBody($request);

        if (!$this->isValidJson($data)) {
            $response = Response::create('Unable to parse json request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
            return;
        }

        $request->request->replace($data);
    }

    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    private function parseBody(Request $request): ?array
    {
        return json_decode($request->getContent(), true);
    }

    private function isValidJson(?array $data): bool
    {
        return !is_null($data);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
