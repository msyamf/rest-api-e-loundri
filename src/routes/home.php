<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/home', function(\Slim\App $app) {
   
    

    $app->post('/chat',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $str = '';
        //$response->withStatus(401);
        if ($input['pembayaran'] == 'lunas'){
            $str = "AND ticket.tanggal_pembayaran = :tanggal_pembayaran";
        }
        $sql = "SELECT sum(transaksi.jumlah * master_harga.m_harga) nominal, master_harga.m_nama FROM transaksi LEFT JOIN master_harga ON transaksi.id_harga=master_harga.m_id_harga LEFT JOIN ticket ON ticket.id_ticket = transaksi.id_ticket WHERE ticket.pembayaran = :pembayaran ".$str." GROUP BY master_harga.m_nama";

        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam(":pembayaran", $input['pembayaran']);
            if ($input['pembayaran'] == 'lunas'){$sth->bindParam(":tanggal_pembayaran", $input['tanggal_pembayaran']);}
            $sth->execute();
            $list = $sth->fetchAll();
            $settings = $this->get('settings'); // get settings array.
            return $this->response->withJson([
                'status'=>'berhasil',
                'proses' => true,
                'data' => $list,
                //'sql'=>$sql
                ]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson([
                'status'=>'gagal',
                'proses' => false,
                'pesan' => $e->getMessage(),
                'sql'=>$sql,'input' => $input
                ]);
        }
 
     });


   
   
});