<?php

return [

    'sql_injection_patterns' => [

        "/(\%27)|(\')|(\-\-)|(\%23)|(#)/i",

        "/\b(OR|AND)\b\s+\d+\s*=\s*\d+/i",

        "/UNION\s+SELECT/i",

        "/DROP\s+TABLE/i",

        "/DELETE\s+FROM/i",

        "/INSERT\s+INTO/i",

        "/UPDATE\s+\w+/i",

        "/information_schema/i",

        "/xp_cmdshell/i",

        "/EXEC(\s|\+)/i",

    ],

];