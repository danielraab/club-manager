<?php

namespace App\Services;

enum NewUserProvider: string
{
    case FORM = 'form';
    case CLI = 'cli';
    case OAUTH = 'oauth';
}
