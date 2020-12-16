<?php
defined('BASEPATH') OR Exit('No direct script access allowed');

class All_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null, $limit = 5, $offset = 0)
    {
        if ($id===null){
            return $this->db->get('all', $limit, $offset)->result();
        }else{
            return $this->db->get_where('all', ['jenis' => $id])->result_array();
        }
    }

    public function hitung(){
        return $this->db->get('all')->num_rows();
    }

    public function tambah($data)
    {
        try{
            $this->db->insert('all',$data);
            $error=$this->db->error();
            if(!empty($error['code'])){
                throw new Exception('Terjadi Kesalahan: '.$error['message']);
                return false;
            }
            return ['status' =>true, 'data'=> $this->db->affected_rows()];
        }
        catch (Exception $ex) {
            return ['status'=>false, 'msg' => $ex->getMessage()];
        }
    }

    public function update($id,$data)
    {
        try{
            $this->db->update('all',$data, ['nama'=> $id]);
            $error=$this->db->error();
            if(!empty($error['code'])){
                throw new Exception('Terjadi Kesalahan: '.$error['message']);
                return false;
            }
            return ['status' =>true, 'data'=> $this->db->affected_rows()];
        }
        catch (Exception $ex) {
            return ['status'=>false, 'msg' => $ex->getMessage()];
        }
    }

    public function delete($id)
    {
        try{
            $this->db->delete('all', ['nama'=> $id]);
            $error=$this->db->error();
            if(!empty($error['code'])){
                throw new Exception('Terjadi Kesalahan: '.$error['message']);
                return false;
            }
            return ['status' =>true, 'data'=> $this->db->affected_rows()];
        }
        catch (Exception $ex) {
            return ['status'=>false, 'msg' => $ex->getMessage()];
        }
    }
}
