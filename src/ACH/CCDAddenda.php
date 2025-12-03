<?php
/**
 * Created by PhpStorm.
 * User: mcasiro
 * Date: 2018-06-14
 * Time: 10:31
 */

namespace RW\ACH;


/**
 * Class CCDAddenda
 *
 * @package RW\ACH
 */
class CCDAddenda extends AddendaRecord
{

    public const CUSTOM_NOTE = 'CUSTOM_NOTE';
    public const SEQUENCE_NUMBER = 'SEQUENCE_NUMBER';
    public const ADDENDA_SEQUENCE_NUMBER = 'ADDENDA_SEQUENCE_NUMBER';
    public const ENTRY_SEQUENCE_NUMBER = 'ENTRY_SEQUENCE_NUMBER';

    public function __construct($fields, $validate)
    {
        return parent::__construct($fields, $validate);
    }

    /**
     * Build a Notice of Change addenda record from an existing string.
     *
     * @param string $input
     * @return CCDAddenda
     * @throws ValidationException
     */
    public static function buildFromString($input): self
    {
        return new CCDAddenda(self::getBuildDataFromInputString($input), false);
    }

    /**
     * Generate the field specifications for each field in the file component.
     * Format is an array of arrays as follows:
     *  $this->fieldSpecifications = [
     *      FIELD_NAME => [
     *          self::FIELD_INCLUSION => Mandatory, Required, or Optional (reserved for future use)
     *          self::VALIDATOR       => array: [
     *              Validation type (self::VALIDATOR_REGEX or self::VALIDATOR_DATE_TIME)
     *              Validation string (regular expression or date-time format)
     *          ]
     *          self::LENGTH          => Required if 'PADDING' is provided: Fixed width of the field
     *          self::POSITION_START  => Starting position within the component (reserved for future use)
     *          self::POSITION_END    => Ending position within the component (reserved for future use)
     *          self::PADDING         => Optional: self::ALPHANUMERIC_PADDING or self::NUMERIC_PADDING
     *          self::CONTENT         => The content to be output for this field
     *      ],
     *      ...
     *  ]
     *
     * @return array
     */
    protected static function getFieldSpecifications(): array
    {
        return [
            self::RECORD_TYPE_CODE => [
                self::FIELD_INCLUSION => self::FIELD_INCLUSION_MANDATORY,
                self::VALIDATOR       => [self::VALIDATOR_REGEX, '/^\d{1}$/'],
                self::LENGTH          => 1,
                self::POSITION_START  => 1,
                self::POSITION_END    => 1,
                self::CONTENT         => self::FIXED_RECORD_TYPE_CODE,
            ],
            self::ADDENDA_TYPE_CODE => [
                self::FIELD_INCLUSION => self::FIELD_INCLUSION_MANDATORY,
                self::VALIDATOR       => [self::VALIDATOR_REGEX, '/^(98|99|05)$/'],
                self::LENGTH          => 2,
                self::POSITION_START  => 2,
                self::POSITION_END    => 3,
                self::CONTENT         => '05',
            ],
            self::CUSTOM_NOTE => [
                self::FIELD_INCLUSION => self::FIELD_INCLUSION_MANDATORY,
                self::VALIDATOR       => [self::VALIDATOR_REGEX, '/^[-a-zA-Z0-9 ]{1,80}$/'],
                self::LENGTH          => 80,
                self::POSITION_START  => 4,
                self::POSITION_END    => 83,
                self::PADDING         => self::ALPHANUMERIC_PADDING,
                self::CONTENT         => null,
            ],
            self::ADDENDA_SEQUENCE_NUMBER => [
                self::FIELD_INCLUSION => self::FIELD_INCLUSION_MANDATORY,
                self::VALIDATOR       => [self::VALIDATOR_REGEX, '/^[0-9]{4}$/'],
                self::LENGTH          => 4,
                self::POSITION_START  => 84,
                self::POSITION_END    => 87,
                self::CONTENT         => '0001',
            ],
            self::ENTRY_SEQUENCE_NUMBER => [
                self::FIELD_INCLUSION => self::FIELD_INCLUSION_MANDATORY,
                self::VALIDATOR       => [self::VALIDATOR_REGEX, '/^[0-9]{7}$/'],
                self::LENGTH          => 7,
                self::POSITION_START  => 88,
                self::POSITION_END    => 94,
                self::CONTENT         => null,
            ],
            
        ];
    }
}
