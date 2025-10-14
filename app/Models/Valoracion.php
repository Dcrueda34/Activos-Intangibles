<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';
    protected $primaryKey = 'ID_Valoracion';

    protected $fillable = [
        'FK_ID_Proyecto',
        'nombre_producto',
        'cantidad_vender',
        'politica_crecimiento',
        'politica_precios',
        'precio',
        'aumento_costos_anual',
        'mano_obra_directa',
        'mano_obra_destajo',
        'aumento_anual_mod_destajo',
        'pago_comision',
        'servicios_publicos',
        'inversion_maquinaria',
        'inversion_muebles',
        'inversion_vehiculos',
        'inversion_tecnologia',
        'porcentaje_aumento_gastos',
        'tasa_oportunidad',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'FK_ID_Proyecto', 'ID_Proyecto');
    }
}
