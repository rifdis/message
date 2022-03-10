<?php

$capabilities = [
    'local/message:managemessages' =>[
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetype' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];