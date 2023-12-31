<?php

return [
    '000' => 'Captured',
    '001' => 'Authorized',
    '100' => 'Initiated',
    '200' => 'In Progress',
    '301' => 'Abandoned',
    '302' => 'Cancelled',
    '303' => 'Deferred',
    '304' => 'Expired',
    '401' => 'Failed',
    '402' => 'Failed, Invalid Parameter',
    '403' => 'Failed, Duplicate',
    '404' => 'Failed, Locked',
    '405' => 'Failed, Invalid Card No',
    '406' => 'Failed, Invalid Expiry',
    '407' => 'Failed, Expired Card',
    '408' => 'Failed, Unspecified Failure',
    '501' => 'Declined',
    '502' => 'Declined, Incorrect CSC/CVV',
    '503' => 'Declined, 3D Security - Incorrect',
    '504' => 'Declined, 3D Security - Card not Enrolled',
    '505' => 'Declined, Insufficient Funds',
    '506' => 'Declined, Transaction Type not Supported',
    '507' => 'Declined, Card Issuer',
    '508' => 'Declined, Card Issuer - No Reply',
    '509' => 'Declined, Card Issuer - Do not Contact',
    '510' => 'Declined, Card Issuer - Referral Response',
    '511' => 'Declined, Card Issuer - Error',
    '512' => 'Declined, Not Authenticated',
    '513' => 'Declined, Card Acquirer - Error',
    '514' => 'Declined, Card Issuer - Risk Check',
    '515' => 'Declined, Tap',
    '601' => 'Void',
    '701' => 'Restricted',
    '702' => 'Restricted, Retry Limit Exceeded',
    '703' => 'Restricted, Bank',
    '704' => 'Restricted, Tap',
    '801' => 'Timed Out',
    '901' => 'Unknown',
];
