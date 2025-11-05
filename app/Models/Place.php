<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Place extends Model
{
    protected $table = "places"; //Vincula o Model places com a tabela do BD

    public function schedules(): HasMany{
        return $this->hasMany(Scheduling::class);
    }
}
