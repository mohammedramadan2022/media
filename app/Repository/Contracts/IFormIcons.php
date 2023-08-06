<?php

namespace App\Repository\Contracts;

interface IFormIcons
{
    public static function getIcons($with_null = null): array;
}
