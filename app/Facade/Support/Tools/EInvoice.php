<?php

namespace App\Facade\Support\Tools;

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class EInvoice
{
    protected static mixed $object;

    public static function of($name, $tax_number, $total, $tax): EInvoice
    {
        static::$object = GenerateQrCode::fromArray([
            new Seller($name), // seller name
            new TaxNumber($tax_number), // seller tax number
            new InvoiceDate(now()->toIso8601ZuluString()), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($total), // invoice total amount
            new InvoiceTaxAmount($tax), // invoice tax amount
        ]);

        return new static();
    }

    public function toBase64(): string
    {
        return static::$object->toBase64();
    }

    public function toImg(): string
    {
        return static::$object->render();
    }
}
