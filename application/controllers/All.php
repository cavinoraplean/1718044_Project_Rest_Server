<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class All extends RestController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('all_model','ftsl');
        $this->methods['index_get']['limit'] = 2;
    }

	public function index_get()
	{
        $id = $this->get('id');
        if ($id === null){
            $p = $this->get('page');
            $p = (empty($p) ? 1 : $p);
            $total_data = $this->ftsl->hitung();
            $total_page = ceil($total_data / 5);
            $start = ($p - 1) * 5;
            $list=$this->ftsl->get(null, 5, $start);
            $data = [
                'status' => true,
                'page' =>$p,
                'total_data' =>$total_data,
                'total_page' =>$total_page,
                'data' => $list
            ];
            $this->response($data, RestController::HTTP_OK);
        } else{
            $data = $this->ftsl->get($id);
            if($data){
                $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
            }else{
                $this->response(['status' => false, 'msg' => $id .'tidak ditemukan'], RestController::HTTP_NOT_FOUND);
            }
            
        }
    }
    
    public function index_post()
    {
        $data=[
            'nama' => $this->post('nama',true),
            'jenis' => $this->post('jenis',true),
            'warna' => $this->post('warna',true),
            'ukuran' => $this->post('ukuran',true),
            'harga' => $this->post('harga',true)
        ];
        $simpan=$this->ftsl->tambah($data);
        if($simpan['status']){
            $this->response(['status'=> true, 'msg'=>$simpan['data']. ' Data telah ditambahkan'], RestController::HTTP_CREATED);
        }
        else{
            $this->response(['status'=>false,'msg'=> $simpan['msg']], RestConstroller::HTTP_INTERNAL_ERROR);
        }
    }

    public function index_put()
    {
        $data=[
            'nama' => $this->put('nama',true),
            'jenis' => $this->put('jenis',true),
            'warna' => $this->put('warna',true),
            'ukuran' => $this->put('ukuran',true),
            'harga' => $this->put('harga',true)
        ];
        $id = $this->put('id',true);
        if($id === null){
            $this->response(['status'=>false, 'msg'=>'Masukkan nama yang ingin dirubah'],RestController::HTTP_BAD_REQUEST);
        }
        $simpan=$this->ftsl->update($id,$data);
        if($simpan['status']){
            $status = (int)$simpan['data'];
            if ($status>0){
                $this->response(['status'=> true, 'msg'=>$simpan['data']. ' Data telah dirubah'], RestController::HTTP_OK);
            }else{
                $this->response(['status'=> false, 'msg'=> 'Tidak ada data yang dirubah'], RestController::HTTP_INTERNAL_ERROR);
            }
        }
        else{
            $this->response(['status'=>false,'msg'=> $simpan['msg']], RestConstroller::HTTP_INTERNAL_ERROR);
        }
    }

    public function index_delete(){
        $id = $this->delete('id',true);
        if($id === null){
            $this->response(['status'=>false, 'msg'=>'Masukkan nama yang ingin dihapus'],RestController::HTTP_BAD_REQUEST);
        }
        $delete=$this->ftsl->delete($id);
        if($delete['status']){
            $status = (int)$delete['data'];
            if ($status>0){
                $this->response(['status'=> true, 'msg'=>$id . ' Data telah dihapus'], RestController::HTTP_OK);
            }else{
                $this->response(['status'=> false, 'msg'=> 'Tidak ada data yang dihapus'], RestController::HTTP_INTERNAL_ERROR);
            }
        }
        else{
            $this->response(['status'=>false,'msg'=> $delete['msg']], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
