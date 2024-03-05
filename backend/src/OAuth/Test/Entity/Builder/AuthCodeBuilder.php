<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\AuthCode\AuthCode;
use App\OAuth\Entity\Scope\Scope;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class AuthCodeBuilder
{
  public function build()
  {
      $code = new AuthCode();

      $code->setClient((new ClientBuilder())->build());
      $code->addScope(new Scope('common'));
      $code->setIdentifier(Uuid::uuid7()->toString());
      $code->setUserIdentifier(Uuid::uuid7()->toString());
      $code->setExpiryDateTime(new DateTimeImmutable());
      $code->setRedirectUri('http://localhost/auth');

      return $code;
  }
}