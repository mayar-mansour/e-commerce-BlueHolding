<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('reservation-channel', function ($user) {
    return true;
});
