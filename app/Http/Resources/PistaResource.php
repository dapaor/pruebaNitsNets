<?php

namespace App\Http\Resources;

use App\Models\Deporte;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PistaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'codigo' => $this->codigo,
          'ancho' => $this->ancho,
          'largo' => $this->largo,
          'deporte' => $this->findDeporteName($this->deporte_id)
        ];
    }

    private function findDeporteName($id)
    {
        return Deporte::find($id)->name;
    }
}
