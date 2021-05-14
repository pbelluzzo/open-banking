<?php

function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }