<?php

namespace App\GraphQL\Directives;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthDirective extends BaseDirective implements FieldMiddleware
{
    public function handleField(FieldValue $fieldValue): void
    {
        $resolver = $fieldValue->getResolver();

        $fieldValue->setResolver(function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($resolver) {
            try {
                if (!auth('api')->check()) {
                    throw new AuthenticationException('Unauthenticated');
                }
            } catch (TokenExpiredException $e) {
                throw new AuthenticationException('Your session has expired. Please log in again.');
            }

            return $resolver($root, $args, $context, $resolveInfo);
        });
    }

    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Require authentication to access this field.
"""
directive @auth on FIELD_DEFINITION
GRAPHQL;
    }
}
