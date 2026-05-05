<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentStatus extends Enum
{
    const NotPaid ='not_paid';
    const Paid ='paid';

    public function __construct($enumValue)
    {
        if (! static::hasValue($enumValue)) {
            //throw new InvalidEnumMemberException($enumValue, $this);
        }
        $this->value = $enumValue;
        $this->key = static::getKey($enumValue);
        $this->description = static::getDescription($enumValue);
    }

    public static function getDescription($value): string
    {
        if ($value === self::NotPaid) {
            return 'Not Paid';
        }

        if ($value === self::Paid) {
            return 'Paid';
        }

        return parent::getDescription($value);
    }
}
