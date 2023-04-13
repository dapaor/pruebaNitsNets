<?php

namespace App\Http\Resources;

use App\Models\Pista;
use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ReservaDiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'socio' => Socio::find($this->socio_id)->dni,
            'pista' => Pista::with('deporte')->where('id', $this->pista_id)->get()->first(),
            'dia' => Carbon::parse($this->dia)->format('d/m/y'),
            'hora' => $this->hora,
        ];
    }
}
