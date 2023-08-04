<?php  
namespace App\Models;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    
   //  protected $table = 'contact_enquiries';

    use HasFactory;

    public function getUser() :HasOne
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function getProduct() :HasOne
    {
        return $this->hasOne('App\Models\Product', 'id', 'user_id');
    }

   
    public function getOrderItem(): HasMany
{
    return $this->hasMany(OrderItem::class);
    //Or: return $this->hasMany(Post::class, 'foreign_key');
}

public function profile(): BelongsTo
{
    return $this->belongsTo(Profile::class);
    //Or: return $this->belongsTo(Profile::class, 'foreign_key');
}

}