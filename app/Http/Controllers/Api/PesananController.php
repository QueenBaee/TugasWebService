<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
//use Illuminate\validation\Validator;

class PesananController extends Controller
{
    public function index(){
        try {
            $pesanan = Pesanan::all();
            return response()->json(['status'=>true, 'message' =>'Data Pesanan Ditemukan', 'data'=> $pesanan], Response::HTTP_OK);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json(['status'=>false, 'message' =>$error], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function findById($kode_pesanan){
        try {
            $pesanan = Pesanan::findOrFail($kode_pesanan);
            $response = [
                'status' => true, 'message' => 'Data Pesanan Ditemukan', 'data' => $pesanan,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data Kosong'], Response::HTTP_NOT_FOUND);
        }
    }

    public function create (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'kode_pesanan'=> 'required|unique:pesanan',
                'total_harga'=> 'required|numeric',
                'metode_pembayaran' => 'required',
                'tanggal'=> 'required',
                'status'=> 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['Status' => false, 'Message' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $pesanan = Pesanan::create($request->all());
            $response = [
                'status' => true, 'message' => 'Data Pesanan Berhasil Ditambahkan', 'data' => $pesanan,
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $request, $kode_pesanan)
    {
        try {
            if (!$kode_pesanan) {
                return response()->json(['status' => false, 'message' => 'Kode Pesanan tidak ditemukan'], Response::HTTP_BAD_REQUEST);
            }

            $pesanan = Pesanan::findOrFail($kode_pesanan);
            $validator = Validator::make($request->all(), [
                'total_harga'=> 'required|numeric',
                'metode_pembayaran' => 'required',
                'tanggal'=> 'required',
                'status'=> 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'Message' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $pesanan->update($request->all());
            $response = [
                'status' => true, 'message' => 'Data Pesanan Berhasil di Update', 'data' => $pesanan,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data Kosong'], Response::HTTP_NOT_FOUND);
        }
    }
       
    public function delete($kode_pesanan){
        try {
            if (!$kode_pesanan) {
                return response()->json(['status' => false, 'message' => 'Kode Pesanan tidak ditemukan'], Response::HTTP_BAD_REQUEST);
            }
            
            Pesanan::findOrFail($kode_pesanan)->delete();
            return response()->json(['status'=>true, 'message' => 'Data Pesanan Berhasil Dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data Pesanan Tidak Ditemukan'], Response::HTTP_NOT_FOUND);
        }
    }
}
