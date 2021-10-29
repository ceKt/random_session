<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessionlist extends Model
{
    protected $fillable = ['content_id', 'session_name', 'rule', 'numpeople','numaccess'];
}
