<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/api/ticket', function(\Slim\App $app) {
    $app->post('/tambah',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "INSERT INTO `ticket` 
       (`id_ticket`, `id_pegawai`, `tanggal`, `nama_pelanggan`, `telp_pelangan`, `alamat_pelanggan`, `status_ticket`)  VALUES 
       (NULL, :id_pegawai, now(),:nama_pelanggan, :telp_pelangan, :alamat_pelanggan, :status_ticket)";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_pegawai", $input['id_pegawai']);
           $sth->bindParam("nama_pelanggan", $input['nama_pelanggan']);
           $sth->bindParam("telp_pelangan", $input['telp_pelangan']);
           $sth->bindParam("alamat_pelanggan", $input['alamat_pelanggan']);
           $sth->bindParam("status_ticket", $input['status_ticket']);
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
       $sql = "DELETE FROM `ticket` WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_ticket", $input['id_ticket']);
           $sth->execute();
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true]);
       }
       catch(PDOException $e)
       {
           return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
       }

    });
    $app->post('/hapus',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "UPDATE `ticket` SET `status_ticket` = 'nonaktif' WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_ticket", $input['id_ticket']);
           $sth->execute();
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true]);
       }
       catch(PDOException $e)
       {
           return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
       }

    });
    $app->post('/batal-hapus',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "UPDATE `ticket` SET `status_ticket` = 'proses' WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_ticket", $input['id_ticket']);
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
        $sql = "SELECT * FROM `ticket`;";
        try
        { 
            $sth = $this->db->prepare($sql);
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