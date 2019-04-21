<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/transaksi', function(\Slim\App $app) {
    $app->post('/tambah',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       $sql = "INSERT INTO `transaksi` (`id_transaksi`, `id_harga`, `tanggal`, `id_pegawai`,`id_ticket`,`jumlah`) VALUES (NULL, :id_harga, now(), :id_pegawai, :id_ticket,:jumlah);";
       $sql2 = "UPDATE `ticket` SET `status_ticket` = 'proses' WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_harga", $input['id_harga']);
           $sth->bindParam("id_ticket", $input['id_ticket']);
           $sth->bindParam("jumlah", $input['jumlah']);
           $sth->bindParam("id_pegawai", $data['id']);
           $sth->execute();

           $sth2 = $this->db->prepare($sql2);
           $sth2->bindParam("id_ticket", $input['id_ticket']);
           $sth2->execute();
           
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true]);
       }
       catch(PDOException $e)
       {
           return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
       }

    });
    $app->post('/selesai',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       $response->withStatus(401);
       
       $sql2 = "UPDATE `ticket` SET `status_ticket` = 'selesai' WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 

           $sth2 = $this->db->prepare($sql2);
           $sth2->bindParam("id_ticket", $input['id_ticket']);
           $sth2->execute();
           
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
       $sql = "DELETE FROM `transaksi` WHERE `transaksi`.`id_ticket` = :id_ticket ;";
       $sql2 = "DELETE FROM `ticket` WHERE `ticket`.`id_ticket` = :id_ticket ;";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_ticket", $input['id_ticket']);
           $sth->execute();
           
           $sth2 = $this->db->prepare($sql2);
           $sth2->bindParam("id_ticket", $input['id_ticket']);
           $sth2->execute();
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