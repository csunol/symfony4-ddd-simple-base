<?php

namespace App\UI\Rest\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionSubscriber
 * @package App\UI\EventSubscriber
 */
class ExceptionSubscriber
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $exception = $event->getException();
        $response->setStatusCode($this->getStatusCode($exception));
        $response->setData($this->getMessage($exception, $response));

        $event->setResponse($response);
    }

    private function getStatusCode(\Exception $exception): int
    {
        if ($exception instanceof \InvalidArgumentException) {
            return Response::HTTP_BAD_REQUEST;
        }

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function getMessage(\Exception $exception, JsonResponse $response): array
    {
        return [
            'errors'=> [
                'title'     => str_replace('\\', '.', \get_class($exception)),
                'detail'    => $exception->getMessage(),
                'code'      => $exception->getCode(),
                'status'    => $response->getStatusCode(),
            ],
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
