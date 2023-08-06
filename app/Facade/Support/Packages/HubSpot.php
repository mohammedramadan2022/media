<?php

namespace App\Facade\Support\Packages;

use STS\HubSpot\Crm\Contact;

class HubSpot
{
    public static function create($firstname, $lastname, $email)
    {
        return Contact::create([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
        ]);
    }
}
