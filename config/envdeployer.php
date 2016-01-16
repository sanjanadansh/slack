<?php

return [

    'connections' => [

        /*
         * The environment name.
         */
        'production' => [

            /*
             * The hostname to send the env file to
             */
            'host'  => '104.131.36.26',

            /*
             * The username to be used when connecting to the server where the logs are located
             */
            'user' => 'vagrant',

            /*
             * The full path to the directory where the .env is located MUST end in /
             */
            'rootEnvDirectory' => '/home/forge/',

            'port' => 2222
        ],
    ],
];
