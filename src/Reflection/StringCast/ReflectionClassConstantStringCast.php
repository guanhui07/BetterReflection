<?php

declare(strict_types=1);

namespace Roave\BetterReflection\Reflection\StringCast;

use Roave\BetterReflection\Reflection\ReflectionClassConstant;

use function assert;
use function gettype;
use function is_array;
use function sprintf;

/** @internal */
final class ReflectionClassConstantStringCast
{
    /**
     * @return non-empty-string
     *
     * @psalm-pure
     */
    public static function toString(ReflectionClassConstant $constantReflection): string
    {
        /** @psalm-var scalar|array<scalar> $value */
        $value = $constantReflection->getValue();

        $string = sprintf(
            "Constant [ %s%s %s %s ] { %s }\n",
            $constantReflection->isFinal() ? 'final ' : '',
            self::visibilityToString($constantReflection),
            gettype($value),
            $constantReflection->getName(),
            is_array($value) ? 'Array' : (string) $value,
        );
        assert($string !== '');

        return $string;
    }

    /** @psalm-pure */
    private static function visibilityToString(ReflectionClassConstant $constantReflection): string
    {
        if ($constantReflection->isProtected()) {
            return 'protected';
        }

        if ($constantReflection->isPrivate()) {
            return 'private';
        }

        return 'public';
    }
}
