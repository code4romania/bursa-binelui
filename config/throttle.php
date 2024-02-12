<?php

declare(strict_types=1);

return [

    'register_limit' => (int) env('THROTTLE_REGISTER_PER_MINUTE', 10),
    'login_limit' => (int) env('THROTTLE_LOGINS_PER_MINUTE', 5),
    'donation_limit' => (int) env('THROTTLE_DONATIONS_PER_MINUTE', 5),
    'volunteer_limit' => (int) env('THROTTLE_VOLUNTEERS_PER_MINUTE', 5),

];
