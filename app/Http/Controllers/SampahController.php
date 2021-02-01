<?php

namespace App\Http\Controllers;

use App\GolonganSampah;
use App\Sampah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\SampahResource;
use RealRashid\SweetAlert\Facades\Alert;

class SampahController extends Controller
{
    public function indexSampah()
    {
        $sampahs   = Sampah::with(['gudang', 'golonganSampah'])->get();
        $golongans = GolonganSampah::get();

        return view('sampah.index')->with(compact('sampahs', 'golongans'));
    }

    public function delete($sampah_id)
    {

        $sampah = Sampah::findOrFail($sampah_id);
        
        try {
            $sampah->delete();
    
            Alert::success('Berhasil', 'Data sampah berhasil di hapus');
            return back();
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Data sampah gagal di hapus');
        }
    }

    public function show($sampah_id)
    {
        Sampah::findOrFail($sampah_id);
    }

    public function tambahSampah(Request $request) 
    {

        $validatedData = $request->validateWithBag('tambah', [
            'golongan_id'     => [ 'required' ],
            'jenis_sampah'    => [ 'required' ,'jenis_sampah'],
            'stok'            => [ 'required' ],
            'harga'           => [ 'required' ],
        ]);
      
        Sampah::create([
            'golongan_sampah_id' => $validatedData['golongan_id'],
            'jenis_sampah' => $validatedData['jenis_sampah'],
            'stok' => $validatedData['stok'],
            'harga_perkilogram' => $validatedData['harga'],
        ]);
        
        Alert::success('Berhasil', 'Sampah baru berhasil ditambahkan');
        return back();
    }

    public function updateSampah(Request $request)
    {
        
        $sampah = Sampah::findOrFail($request->sampah_id);

        $validatedData = $request->validateWithBag('tambah', [
            'golongan_id'     => [ 'required' ],
            'jenis_sampah'    => [ 'required' ,'jenis_sampah'],
            'stok'            => [ 'required' ],
            'harga'           => [ 'required' ],
        ]);
      
        Sampah::create([
            'golongan_sampah_id' => $validatedData['golongan_id'],
            'jenis_sampah' => $validatedData['jenis_sampah'],
            'stok' => $validatedData['stok'],
            'harga_perkilogram' => $validatedData['harga'],
        ]);
        
        Alert::success('Berhasil', 'Sampah baru berhasil ditambahkan');
        return back();

        $validatedData = $request->validateWithBag('edit', [
            'name'            => [ 'nullable', 'string'],
            'email'           => [ 'nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'password'        => [ 'nullable', 'min:6' ],
            'no_telephone'    => [ 'nullable', Rule::unique('users')->ignore($user->id) ],
            'location'        => [ 'nullable' ],
            'profile_picture' => [ 'nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png' ],
        ]);


        $input = collect($validatedData)->filter(function($value, $key) {
            return $value != null;
        });

        $input = $input->map(function($value, $key) use($pp) {
            if ( $key == 'password' ) {
                $value = Hash::make($value);
            }
            if( $key == 'profile_picture') {
                $value = $pp;
            }
            return $value;
        });

        $user->update($input->toArray());

        Alert::success('Berhasil', 'Data sampah berhasil di update');
        return back();
    }
}
