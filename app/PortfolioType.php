<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioType extends Model
{
    /**
     * @var array
     */
    protected $fillable = [ 'portfolio_id', 'type_id' ];

    /**
     * @var string
     */
    protected $table = 'portfolio_types';

    /**
     * @var bool
     */
    public $timestamps = false;
}
