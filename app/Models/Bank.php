<?php

/*
 * This file is part of the IndoBank package.
 *
 * (c) Andri Desmana <andridesmana.pw | andridesmana29@gmail.com>
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bank Model.
 */
class Bank extends Model
{
    use HasFactory;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'banks';

    /**
     * Primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Fillable column.
     *
     * @var array
     */

    protected $fillable = [
        'sandi_bank', 'nama_bank'
    ];
}
