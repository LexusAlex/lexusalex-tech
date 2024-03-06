<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\AuthCode\AuthCode;
use App\OAuth\Entity\Scope\Scope;
use DateTimeImmutable;

final class AuthCodeBuilder
{
    public function build(): AuthCode
    {
        $code = new AuthCode();

        $code->setClient((new ClientBuilder())->build());
        $code->addScope(new Scope('common'));
        $code->setIdentifier('018e13f4-7cdb-71a8-be03-ce8496c869c5');
        $code->setUserIdentifier('018e13f4-7cdb-71a8-be03-ce8496c869c5');
        $code->setExpiryDateTime(new DateTimeImmutable());
        $code->setRedirectUri('http://localhost/auth');

        return $code;
    }
}
