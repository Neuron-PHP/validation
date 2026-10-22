[![CI](https://github.com/Neuron-PHP/validation/actions/workflows/ci.yml/badge.svg)](https://github.com/Neuron-PHP/validation/actions)
[![codecov](https://codecov.io/gh/Neuron-PHP/validation/branch/develop/graph/badge.svg)](https://codecov.io/gh/Neuron-PHP/validation)
# Neuron-PHP Validation

Validators for common values (email, dates, phone numbers, images, passwords) plus a way to combine them. Each validator answers one question: `isValid()`.

## Installation

Requires PHP 8.4 or higher and [neuron-php/data](https://packagist.org/packages/neuron-php/data).

```bash
composer require neuron-php/validation
```

## Validating a value

Every validator implements `Neuron\Validation\IValidator`.

```php
use Neuron\Validation\IsEmail;

$Validator = new IsEmail();

if( $Validator->isValid( 'lee@example.com' ) )
{
	// accepted
}
```

Built-in validators extend `Neuron\Validation\Base`. Call `isValid()`; the class implements the check in `validate()`.

### Several checks on one value

`Collection` runs named validators against the same value. `getViolations()` returns the names of the checks that failed.

```php
use Neuron\Validation\Collection;
use Neuron\Validation\IsInteger;
use Neuron\Validation\IsPositive;

$Rules = new Collection();
$Rules->add( 'positive', new IsPositive() );
$Rules->add( 'integer', new IsInteger() );

if( !$Rules->isValid( -1 ) )
{
	$Failed = $Rules->getViolations(); // [ 'positive' ]
}

$Rules->get( 'positive' );
$Rules->remove( 'positive' );
```

### One check per field

`Policy` is a trait. `addRule()` stores a validator under a name, and `isRuleValid()` runs it. A rule's validator can be a single check or a `Collection`.

```php
use Neuron\Validation\IsEmail;
use Neuron\Validation\Policy;

class Registration
{
	use Policy;

	public function __construct()
	{
		$this->addRule( 'email', new IsEmail() );
	}

	public function emailIsValid( string $Email ): bool
	{
		return $this->isRuleValid( 'email', $Email );
	}
}
```

## Validators

| Class | Accepts |
| --- | --- |
| `IsArray` | An array |
| `IsBase64` | A base64 string. URL-safe (`-` and `_`) is accepted unless you pass `false` |
| `IsBoolean` | A bool. Loose mode also accepts `0`, `1`, `'0'`, `'1'`, `true`, `false`, `on`, `off`, `yes`, and `no` |
| `IsCurrency` | A number with at most two decimal places, such as `1`, `1.01`, or `-1.01`. No symbol and no thousands separator |
| `IsDate` | A date string in a format. Default `Y-m-d`, so `2015-01-01` |
| `IsDateRange` | A `Neuron\Data\Objects\DateRange` whose start is before its end |
| `IsDateTime` | A date and time string. Default `Y-m-d H:i:s`, so `2015-01-01 14:15:16` |
| `IsDateWithinRange` | A date string that matches the format and falls inside a `DateRange`, including the endpoints |
| `IsEin` | An employer identification number, `NN-NNNNNNN` |
| `IsEmail` | An email address |
| `IsFloatingPoint` | A float, or a numeric string such as `3.14`. An int is rejected |
| `IsImage` | Base64 image bytes, or a `data:image/...;base64,...` URI. See below |
| `IsInSet` | A value from a list. Comparison is strict unless you pass `false` |
| `IsInteger` | An int. The string `'1'` is rejected |
| `IsIpAddress` | An IPv4 or IPv6 address |
| `IsJson` | A string of JSON. The JSON value `null`, and anything that is not a string, is rejected |
| `IsName` | Letters, spaces, periods, and commas, such as `Dr. Lee Jones, PHD` |
| `IsNotEmpty` | A value PHP treats as non-empty. `0`, `'0'`, `false`, `null`, `''`, and `[]` fail |
| `IsNotNull` | Anything other than `null` |
| `IsNumberWithinRange` | A number inside a `NumericRange`, including the endpoints |
| `IsNumeric` | An int, a float, or a numeric string |
| `IsNumericRange` | A `NumericRange` whose minimum is less than its maximum |
| `IsObject` | An object |
| `IsPassword` | A string that meets the length and character rules you pass in |
| `IsPhoneNumber` | A US number `###-###-####`, or an international number when you ask for one |
| `IsPositive` | A number greater than or equal to zero |
| `IsRegExPattern` | A string that matches the pattern you pass in |
| `IsString` | A string |
| `IsStringLength` | A string whose length is between the minimum and maximum, inclusive |
| `IsTime` | A time string. Default `g:i:s A`, so `1:30:23 PM` |
| `IsUpc` | A 12-digit UPC with a valid check digit, such as `123456789012` |
| `IsUrl` | A URL, such as `http://example.org` |
| `IsUuid` | A UUID, `8-4-4-4-12` hexadecimal. Case does not matter |

### Dates and times

`IsDate`, `IsDateTime`, and `IsTime` compare the value to itself after parsing, so the string has to already be in the format. Change the format with `setFormat()`. `IsTime` also has `getFormat()`.

```php
use Neuron\Validation\IsDate;
use Neuron\Validation\IsDateTime;
use Neuron\Validation\IsTime;

$Date = new IsDate();
$Date->setFormat( 'Y-m-d' );
$Date->isValid( '2015-01-01' );

$DateTime = new IsDateTime();
$DateTime->isValid( '2015-01-01 14:15:16' );

$Time = new IsTime();
$Time->isValid( '1:30:23 PM' );
```

`IsDateWithinRange` uses the same date format (default `Y-m-d`) and requires the date to fall inside the range. `DateRange` stores its endpoints as `Y-m-d`.

```php
use Neuron\Data\Objects\DateRange;
use Neuron\Validation\IsDateWithinRange;

$Validator = new IsDateWithinRange(
	new DateRange( '2024-01-01', '2024-12-31' )
);

$Validator->isValid( '2024-06-01' );
```

`IsDateRange` checks the range object itself: `start` must be earlier than `end`.

```php
use Neuron\Data\Objects\DateRange;
use Neuron\Validation\IsDateRange;

$Validator = new IsDateRange();
$Validator->isValid( new DateRange( '2000-01-01', '2000-01-03' ) );
```

### Numbers

```php
use Neuron\Data\Objects\NumericRange;
use Neuron\Validation\IsCurrency;
use Neuron\Validation\IsNumberWithinRange;
use Neuron\Validation\IsNumericRange;

( new IsCurrency() )->isValid( '1.01' );

$Within = new IsNumberWithinRange( new NumericRange( 1, 10 ) );
$Within->isValid( 10 );

$Range = new IsNumericRange();
$Range->isValid( new NumericRange( 1, 10 ) );
```

### Strings, sets, and passwords

```php
use Neuron\Validation\IsInSet;
use Neuron\Validation\IsPassword;
use Neuron\Validation\IsRegExPattern;
use Neuron\Validation\IsStringLength;

( new IsStringLength( 3, 10 ) )->isValid( 'test' );

( new IsInSet( [ 'admin', 'editor' ] ) )->isValid( 'admin' );
( new IsInSet( [ 1, 2, 3 ], false ) )->isValid( '2' );

( new IsRegExPattern( '/^SKU-\d+$/' ) )->isValid( 'SKU-100' );

$Password = new IsPassword(
	minLength: 12,
	maxLength: 64,
	requireUppercase: true,
	requireLowercase: true,
	requireDigit: true,
	requireSpecial: true
);

$Password->isValid( 'MyP@ssw0rd!!' );
```

`IsPassword` requires a minimum length. Maximum length, uppercase, lowercase, a digit, and a special character are optional. The default special-character set is `!@#$%^&*()_+-=[]{}|;:,.<>?`. Pass `specialChars` to use a different set.

### Phone numbers

The default type is `IsPhoneNumber::US`, which requires `###-###-####`.

```php
use Neuron\Validation\IsPhoneNumber;

$Us = new IsPhoneNumber();
$Us->isValid( '941-248-3500' );

$International = new IsPhoneNumber( IsPhoneNumber::INTERNATIONAL );
$International->isValid( '+49 89 636 48098' );
```

An international number starts with `+` and contains 7 to 15 digits. Single spaces may separate digits. `setType()` switches an existing validator.

### Images and base64

`IsBase64` rejects an empty string. Whitespace is ignored. URL-safe base64 is accepted by default; pass `false` to require `+` and `/`.

```php
use Neuron\Validation\IsBase64;

$Validator = new IsBase64();
$Validator->isValid( 'SGVsbG8=' );
```

`IsImage` accepts raw base64 or a data URI. By default it allows JPEG, PNG, GIF, and WebP, and it checks the decoded bytes. SVG is rejected unless you opt in, because SVG can contain scripts.

```php
use Neuron\Validation\IsImage;

new IsImage();
new IsImage( [ 'image/png' ], 1024 * 1024 );
new IsImage( allowedMimeTypes: [ 'image/png' ], allowSvg: true );
```

The constructor arguments are the allowed MIME types, a maximum decoded size in bytes (`null` for no limit), whether to inspect the image bytes, and whether to allow SVG.

### Booleans

```php
use Neuron\Validation\IsBoolean;

( new IsBoolean() )->isValid( true );
( new IsBoolean( true ) )->isValid( 'yes' );
```

## Writing a validator

Extend `Base` and implement `validate()`, or implement `IValidator` directly. Either can be passed to `Collection` and `Policy`.

```php
use Neuron\Validation\Base;

class IsEven extends Base
{
	protected function validate( mixed $Value ): bool
	{
		return is_int( $Value ) && $Value % 2 === 0;
	}
}
```

## More Information

- **Neuron Framework**: [neuronphp.com](http://neuronphp.com)
- **GitHub**: [github.com/neuron-php/validation](https://github.com/neuron-php/validation)
- **Packagist**: [packagist.org/packages/neuron-php/validation](https://packagist.org/packages/neuron-php/validation)

## License

MIT License - see LICENSE file for details
