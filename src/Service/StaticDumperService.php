<?php

namespace App\Service;

use App\Controller\BlogController;
use App\Controller\HomeController;
use Symplify\SymfonyStaticDumper\Contract\ControllerWithDataProviderInterface;

final class StaticDumperService implements ControllerWithDataProviderInterface
{
    private $notionService;

    public function __construct(NotionService $notionService)
    {
        $this->notionService = $notionService;
    }

    public function getControllerClass(): string
    {
        return HomeController::class;
    }

    public function getControllerMethod(): string
    {
        return '__invoke';
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        $id = [];

        foreach ($this->notionService->getAll() as $formation) {
            $id[] = $formation['id'];
        }

        return $id;
    }
}
