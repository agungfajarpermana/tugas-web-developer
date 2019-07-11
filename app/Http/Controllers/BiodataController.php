<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Http\Requests\ErrorRequestFormBiodata;

class BiodataController extends Controller
{
    public function GetDataBio(Request $request)
    {
        if(!$request->ajax()) dd('Woow, hayo mau ngapain!');

        $biodata = Biodata::orderBy('nama','asc')->get();
        return response()->json($biodata);
    }

    public function CreateBio(ErrorRequestFormBiodata $request)
    {
        if(!$request->ajax()) dd('Woow, hayo mau ngapain!');

        try{
            DB::connection()->getPdo();
            DB::beginTransaction();

            try{
                $data = Biodata::create([
                    'nama'      => $request->nama,
                    'no_telp'   => $request->no_telp,
                    'email'     => $request->email,
                    'pesan'     => $request->pesan,
                    'alamat'    => $request->alamat
                ]);
                
                DB::commit();
                return response()->json(['status'=>true, 'msg'=>'Berhasil Ditambahkan!', 'data'=>$data]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['status'=>false, 'msg'=>'Ada masalah saat memasukan data biodata!', 'error' => $e->getMessage()]);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'msg'=>'Koneksi Ke Database Terputus!', 'error' => $e->getMessage()]);
        }
    }

    public function UpdateBio(ErrorRequestFormBiodata $request, $id)
    {
        if(!$request->ajax()) dd('Woow, hayo mau ngapain!');

        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {
                $data = Biodata::where('id', $id)->update([
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'no_telp'   => $request->no_telp,
                    'pesan'     => $request->pesan,
                    'alamat'    => $request->alamat
                ]);
                    
                DB::commit();
                return response()->json(['status'=>true, 'msg'=>'Berhasil Diubah!', 'data'=>$data]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status'=>false, 'msg'=>'Ada masalah saat mengubah data biodata!', 'error' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false, 'msg'=>'Koneksi Ke Database Terputus!', 'error' => $e->getMessage()]);
        }
    }

    public function deleteBio(Request $request, $id)
    {
        if(!$request->ajax()) dd('Woow, hayo mau ngapain!');

        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {
                $delete = Biodata::findOrfail($id);
                $data = $delete->delete();

                DB::commit();
                return response()->json(['status'=>true, 'msg'=>'Berhasil Dihapus!', 'data'=>$data]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status'=>false, 'msg'=>'Ada masalah saat menghapus data biodata!', 'error' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false, 'msg'=>'Koneksi Ke Database Terputus!', 'error' => $e->getMessage()]);
        }
    }
}
