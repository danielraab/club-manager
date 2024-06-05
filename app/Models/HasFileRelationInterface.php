<?php

namespace App\Models;

interface HasFileRelationInterface
{
    public function hasFileAccess(?User $user): bool;
}
