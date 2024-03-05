<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Entity\AuthCode;

use App\OAuth\Entity\AuthCode\AuthCodeRepository;
use App\OAuth\Test\Entity\Builder\AuthCodeBuilder;
use Psr\Container\ContainerInterface;
use Test\Functional\WebTestCase;

final class AuthCodeRepositoryTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $code = new AuthCodeBuilder();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);

        /*
        echo "<pre>";
        print_r($repository->persistNewAuthCode($code->build()));
        exit();
        */
    }
}
