<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/api/ticket', function(\Slim\App $app) {
    $app->post('/tambah',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "INSERT INTO `transaksi` (`id_transaksi`, `id_harga`, `tanggal`, `id_pegawai`) VALUES (NULL, :id_harga, now(), :id_pegawai);";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_harga", $input['id_harga']);
           $sth->bindParam("id_pegawai", $input['id_pegawai']);
           $sth->execute();
           
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true]);
       }
       catch(PDOException $e)
       {
           return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
       }

    });

    $app->post('/hapus-permanen',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "DELETE FROM `transaksi` WHERE `transaksi`.`id_transaksi` = :id_transaksi ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_transaksi", $input['id_transaksi']);
           $sth->execute();
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true]);
       }
       catch(PDOException $e)
       {
           return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
       }

    });

    $app->post('/list',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "SELECT * FROM `transaksi` WHERE `transaksi`.`id_transaksi` = :id_transaksi;";
        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam("id_transaksi", $input['id_transaksi']);
            $sth->execute();
            $list = $sth->fetchAll();
            $settings = $this->get('settings'); // get settings array.
            return $this->response->withJson(['status'=>'berhasil','proses' => true,'data' => $list]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
        }
 
     });
   
});