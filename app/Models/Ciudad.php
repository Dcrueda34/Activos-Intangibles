<?php
// Ciudad.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudad';
    protected $primaryKey = 'ID_Ciudad';
    public $timestamps = false;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'FK_ID_Departamento', 'ID_Departamento');
    }
}
