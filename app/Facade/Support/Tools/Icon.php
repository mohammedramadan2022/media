<?php

namespace App\Facade\Support\Tools;

use App\Repository\Contracts\IFormIcons;

class Icon
{
    public function __construct(public IFormIcons $formIcons) {}

    private function get_icons(): array
    {
        return $this->formIcons::getIcons();
    }

    public static function getIcons(): array
    {
        return (new static(app(IFormIcons::class)))->get_icons();
    }
}
