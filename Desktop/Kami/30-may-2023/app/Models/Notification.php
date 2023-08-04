<?php  
namespace App\Models;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'body', 'not_from', 'not_to' , 'link'];   
   //  protected $table = 'contact_enquiries';

    use HasFactory;
}