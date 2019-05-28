<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/ticket', function(\Slim\App $app) {
    $app->post('/tambah',function(Request $request, Response $response, array $args) {
       $input = $request->getParsedBody();
       $data = $request->getAttribute('token');
       
       $response->withStatus(401);
       $sql = "INSERT INTO `ticket` 
       (`id_ticket`, `id_pegawai`, `tanggal`, `nama_pelanggan`, `telp_pelangan`, `alamat_pelanggan`, `status_ticket`)  VALUES 
       (:id_ticket, :id_pegawai, now(),:nama_pelanggan, :telp_pelangan, :alamat_pelanggan, 'baru')";
       
       $sql2 = "SELECT * FROM `ticket` WHERE `ticket`.`id_ticket` = :id_ticket";
       try
       { 
           $sth = $this->db->prepare($sql);
           $sth->bindParam("id_pegawai", $data['id']);
           $sth->bindParam("id_ticket", $input['id_ticket']);
           $sth->bindParam("nama_pelanggan", $input['nama_pelanggan']);
           $sth->bindParam("telp_pelangan", $input['telp_pelangan']);
           $sth->bindParam("alamat_pelanggan", $input['alamat_pelanggan']);
           $sth->execute();
           $sth2 = $this->db->prepare($sql2);
           $sth2->bindParam("id_ticket", $input['id_ticket']);
           $sth2->execute();
           $list = $sth2->fetchAll();
           $settings = $this->get('settings'); // get settings array.
           return $this->response->withJson(['status'=>'berhasil','proses' => true,'data'=> $list]);
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
    $app->post('/lunas',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "UPDATE `ticket` SET `pembayaran` = 'lunas' WHERE `ticket`.`id_ticket` = :id_ticket ;";
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
     $app->post('/belum-lunas',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "UPDATE `ticket` SET `pembayaran` = 'belum lunas' WHERE `ticket`.`id_ticket` = :id_ticket ;";
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
        $sql = "SELECT *,DATE_FORMAT(tanggal,'%d  %M  %Y') tgl FROM `ticket` ORDER BY tanggal DESC LIMIT :limit OFFSET :offset ;";
        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam(":limit", $input['limit'], PDO::PARAM_INT);
            $sth->bindParam(":offset", $input['offset'], PDO::PARAM_INT);
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


    $app->post('/detail',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "SELECT *,DATE_FORMAT(tanggal,'%d  %M  %Y') tgl FROM `ticket` JOIN `pengguna` ON `pengguna`.`id` = `ticket`.`id_pegawai` WHERE `ticket`.`id_ticket`= :id ;";
        
        $sql3 = "SELECT * FROM master_harga ;";

        $sql2 = "SELECT 
                master_harga.m_nama m_nama,
                transaksi.jumlah jumlah,
                round(transaksi.jumlah * master_harga.m_harga,0) jumlah_x_harga,
                master_harga.m_harga m_harga,
                DATE_FORMAT(transaksi.tanggal,'%d  %M  %Y') tgl 
                FROM `transaksi` JOIN master_harga ON transaksi.id_harga = master_harga.m_id_harga WHERE `transaksi`.`id_ticket`= :id ;";
        
        $sql4 = "SELECT sum(round(transaksi.jumlah * master_harga.m_harga,0)) total FROM `transaksi` JOIN master_harga ON transaksi.id_harga = master_harga.m_id_harga WHERE `transaksi`.`id_ticket`= :id ;";
        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam(":id", $input['id_ticket']);
            $sth->execute();
            $list = $sth->fetchAll();

            $sth2 = $this->db->prepare($sql2);
            $sth2->bindParam(":id", $input['id_ticket']);
            $sth2->execute();
            $list2 = $sth2->fetchAll();

            $sth3 = $this->db->prepare($sql3);
            $sth3->execute();
            $list3 = $sth3->fetchAll();

            $sth4 = $this->db->prepare($sql4);
            $sth4->bindParam(":id", $input['id_ticket']);
            $sth4->execute();
            $list4 = $sth4->fetchAll();

            $settings = $this->get('settings'); // get settings array.
            return $this->response->withJson(['status'=>'berhasil','proses' => true,'ticket' => $list,'transaksi' => $list2,'list_harga' => $list3,'total' => $list4[0]['total']]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
        }
 
     });
   
});