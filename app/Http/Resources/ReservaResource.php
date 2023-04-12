<?php

namespace App\Http\Resources;

use App\Models\Pista;
use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'socio' => Socio::find($this->socio_id)->dni,
            'pista' => Pista::find($this->pista_id)->codigo,
            'dia' => Carbon::parse($this->dia)->format('d/m/y'),
            'hora' => $this->hora
        ];
    }
}
