<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Redis;
use Illuminate\validation\Validator;

class PesananController extends Controller
{
    public function index(){
        $pesanan = Pesanan::all();
        if ($pesanan ->count() > 0){
            return response()->json(['status'=>true, 'message' =>'Data Pesanan ditemukan', 'data'=> $pesanan]);
        }else{
            return response()->json(['status'=>false, 'message' =>'Data Pesanan kosong']);
        }
    }
    public function findById($id){
        $pesanan = Pesanan::where('id',$id)->get();
        if ($pesanan ->count() > 0){
            return response()->json(['status'=>true, 'message'=> 'Data Pesanan Ditemukan', 'data'=> $pesanan]);
        }else{
            return response()->json(['status'=>false, 'message'=> 'Data Kosong']);
        }
    }
    public function create (Request $request){
        $validator = $request->validate(['kode_pesanan'=>'required',
        'total_harga'=> 'required',
        'metode_pembayaran' => 'required',
        'tanggal'=> 'required',
        'status'=> 'required',]);
        
        $pesanan = Pesanan::create($validator);
            return response()->json(['status' => true, 'message' => 'Data pesanan berhasil ditambahkan', 'data' => $pesanan]);
        
    }
    public function update(Request $request, $id){
        $pesanan = Pesanan::where('id',$id)->update($request->all());

        if(!$pesanan){
            return response()->json(['status'=>false, 'message'=> 'data pesanan tidak ditemukan']);
        }
        $pesanan->update($request->all());
        return response()->json(['status' => true, 'message' => 'Data pesanan berhasil di update', 'data' => $pesanan]);
    }
    public function delete($id){
        $pesanan = Pesanan::where('id',$id)->first();
        if(!$pesanan){
            return response()->json(['status'=>false, 'message'=> 'Data Pesanan Tidak Ditemukan']);
        }
        $pesanan->delete();
        return response()->json(['status' => true, 'message' => 'Data pesanan berhasil di Hapus', 'data' => $pesanan]);
    }
}
