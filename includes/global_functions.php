<?php
function route($uri)
{
    return BASE_URL . "$uri";
}

function user()
{
    $userArr = App\Models\User::getCurrentUser() ?? [];
    $user = new App\Models\User();
    foreach ($userArr as $key => $value) {
        $user->$key = $value;
    }
    return $user;
}

function asset($asset)
{
    $assetFile = [];
    if (str_starts_with($asset, "js")) {
        $assetFile['type'] = 'js';
        $assetFile['path'] = BASE_URL . "/public/{$asset}";
    } else if (str_starts_with($asset, "css")) {
        $assetFile['type'] = 'css';
        $assetFile['path'] = BASE_URL . "/public/{$asset}";
    }
    return $assetFile;
}
