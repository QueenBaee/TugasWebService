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
    public function findById($kode_pesanan){
        $pesanan = Pesanan::where('kode_pesanan',$kode_pesanan)->get();
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
            return response()->json(['status' => 201, 'message' => 'Data pesanan berhasil ditambahkan', 'data' => $pesanan]);
        
    }
    public function update(Request $request, Pesanan $pesanan){
        if(!$pesanan){
            return response()->json(['status'=>false, 'message'=> 'data pesanan tidak ditemukan']);
        }
        $kode_pesanan = $request->input('kode_pesanan');
        $total_harga = $request->input('total_harga');
        $tanggal = $request ->input('tanggal');
        $status = $request->input('status');
        
       $pesanan -> update(['kode_pesanan'=>'required',
        'total_harga'=> 'required',
        'metode_pembayaran' => 'required',
        'tanggal'=> 'required',
        'status'=> 'required',]);

        return response()->json(['status' => 200, 'message' => 'Data pesanan berhasil di update', 'data' => $pesanan]);
}
    public function delete($kode_pesanan){
        $pesanan = Pesanan::where('kode_pesanan',$kode_pesanan)->first();
        if(!$pesanan){
            return response()->json(['status'=>false, 'message'=> 'Data Pesanan Tidak Ditemukan']);
        }
        $pesanan->delete();
        return response()->json(['status' => 204, 'message' => 'Data pesanan berhasil di Hapus', 'data' => $pesanan]);
    }
}
