<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\ORM\Types;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType as BaseDateTimeType;
use Doctrine\DBAL\Types\Types;

class DateTimeType extends BaseDateTimeType
{
    // const CARBON_DATETIME = 'carbon';

    public function getName()
    {
        return Types::DATETIME_MUTABLE;;
    }

    // public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    // {
    //     return 'CHAR(25)';
    // }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }
        
        if ($value->value() instanceof DateTimeInterface) {
            return $value->value()->format(
                format: $platform->getDateTimeFormatString()
            );
        }

        throw ConversionException::conversionFailedInvalidType(
            value: $value->value(),
            toType: $this->getName(),
            possibleTypes: ['null', 'DateTime']
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value)
            return null;

        return new DateTimeImmutable(
            datetime: $value
        );
    }

    // public function requiresSQLCommentHint(AbstractPlatform $platform)
    // {
    //     return true;
    // }
}
