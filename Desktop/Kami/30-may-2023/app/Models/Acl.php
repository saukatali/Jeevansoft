<?php  
namespace App\Models;  
use Illuminate\Database\Eloquent\Model;  
class Acl extends Model  
{  
    
    protected $table = 'acls'; 
    
    public function parent_data(){
        return $this->hasOne('App\Models\Acl', 'id', 'parent_id');
    }


}  