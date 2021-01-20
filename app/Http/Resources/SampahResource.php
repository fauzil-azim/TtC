<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SampahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = new User;

        return [
            'id' => $this->id,
            'golongan_sampah_id' => $this->golongan_sampah_id,
            'golongan_sampah' => $this->golonganSampah->golongan,
            'jenis_sampah' => $this->jenis_sampah,
            'harga_perkilogram' => $this->when($user->hasRole('pengurus-satu'), $this->harga_perkilogram),
            'harga_jual_perkilogram' => $this->when($user->hasRole('pengurus-dua'), $this->harga_jual_perkilogram),
        ];
    }
}