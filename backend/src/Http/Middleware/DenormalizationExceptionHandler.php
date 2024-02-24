<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Configurations\Validator\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

final class DenormalizationExceptionHandler implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ExtraAttributesException $exception) {
            throw new ValidationException(
                new ConstraintViolationList(
                    array_map(self::attributeToViolation(...), $exception->getExtraAttributes())
                )
            );
        } catch (NotNormalizableValueException $exception) {
            throw new ValidationException(
                new ConstraintViolationList(
                    [self::errorToViolation($exception)]
                )
            );
        } catch (PartialDenormalizationException $exception) {
            throw new ValidationException(
                new ConstraintViolationList(
                    array_map(self::errorToViolation(...), $exception->getErrors())
                )
            );
        }
    }

    private static function attributeToViolation(string $attribute): ConstraintViolation
    {
        return new ConstraintViolation('The attribute is not allowed.', '', [], null, $attribute, null);
    }

    private static function errorToViolation(NotNormalizableValueException $exception): ConstraintViolation
    {
        /** @var string[] $types */
        $types = $exception->getExpectedTypes();
        /** @var string $currentType */
        $currentType = $exception->getCurrentType();

        $message = sprintf(
            'The type must be one of "%s" ("%s" given).',
            implode(', ', $types),
            $currentType
        );

        return new ConstraintViolation($message, '', [], null, $exception->getPath(), null);
    }
}
