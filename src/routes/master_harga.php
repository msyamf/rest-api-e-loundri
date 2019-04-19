<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/m-harga', function(\Slim\App $app) {
    $app->post('/tambah',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "INSERT INTO `master_harga` (`m_nama`, `m_harga`, `status`) VALUES (:m_nama, :m_harga, 'aktif');";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("m_nama", $input['m_nama']);
           $sth->bindParam("m_harga", $input['m_harga']);
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
       $sql = "DELETE FROM `master_harga` WHERE `master_harga`.`m_id_harga` = :id";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id", $input['id']);
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
       $sql = "UPDATE `master_harga` SET `status` = 'nonaktif' WHERE `master_harga`.`m_id_harga` = :id;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id", $input['id']);
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
       $sql = "UPDATE `master_harga` SET `status` = 'aktif' WHERE `master_harga`.`m_id_harga` = :id;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id", $input['id']);
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
        $sql = "SELECT * FROM `master_harga`";
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