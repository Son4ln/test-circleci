<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioStyle extends Model
{
    /**
     * @var array
     */
    protected $fillable = [ 'portfolio_id', 'style_id' ];

    /**
     * @var string
     */
    protected $table = 'portfolio_styles';

    /**
     * @var bool
     */
    public $timestamps = false;
}
