<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SmtpSetting extends Model {
    protected $fillable = ['host','port','encryption','username','password','from_address','from_name','active','tested_at','last_test_ok'];
    protected $hidden = ['password'];
    protected $casts = ['active'=>'boolean','last_test_ok'=>'boolean','tested_at'=>'datetime','password'=>'encrypted'];
}
