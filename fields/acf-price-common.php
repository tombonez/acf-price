<?php

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class acf_price_common extends acf_field
{
    public function __construct( $settings )
    {
        $this->name = 'price';
        $this->label = __('Price', 'acf-price');
        $this->category = 'jQuery';
        $this->settings = $settings;
        $this->formats = array(
            '|2/./ |'   => '1 337.55',
            '|2/,/ |'   => '1 337,55',
            '|2/./,|'   => '1,337.55',
            '|2/,/.|'   => '1.337,55',
            '|0//|'     => '1337',
            '|0// |'    => '1 337'
        );
        $this->defaults = array(
            'format'                => '|2/./ |'
        );

        $this->l10n = array(
            //'error'   => __('Error! Please enter a higher value', 'acf-price'),
        );

        parent::__construct();
    }

    public function parse_format( $format )
    {
        if ( ! is_string( $format ) || '' === $format ) {
            $format = $this->defaults['format'];
        }

        $elements = explode( '/', str_replace( '|', '', $format ) );

        if ( count( $elements ) !== 3 ) {
            return $this->parse_format( $this->defaults['format'] );
        }

        return array(
            'decimals'              => (int) $elements[0],
            'decimal_point'         => $elements[1],
            'thousands_separator'   => $elements[2]
        );
    }

    public function update_value( $value, $post_id, $field )
    {
        $format = $this->parse_format( $field['format'] ?? $this->defaults['format'] );

        if ( ! is_scalar( $value ) ) {
            return '';
        }

        // Strip the configured thousands separator and normalise the decimal
        // point, so the value is stored as a plain float string.
        $value = str_replace(
            array( $format['thousands_separator'], $format['decimal_point'] ),
            array( '', '.' ),
            (string) $value
        );

        // Remove anything other than digits, a decimal point and a minus.
        // Catches values that never passed through the client-side mask
        // (REST API, WP-CLI, imports, front-end acf_form()).
        $value = preg_replace( '/[^0-9.\-]/', '', $value );

        return is_numeric( $value ) ? (string) (float) $value : '';
    }

    public function format_value( $value, $post_id, $field )
    {
        $format = $this->parse_format( $field['format'] ?? $this->defaults['format'] );

        // Cast up front: legacy or imported meta may hold non-numeric strings,
        // and number_format() throws a TypeError on those under PHP 8.
        return number_format( (float) $value, $format['decimals'], $format['decimal_point'], $format['thousands_separator'] );
    }
}
