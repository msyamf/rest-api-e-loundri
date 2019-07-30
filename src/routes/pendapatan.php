

<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->group('/pendapatan', function(\Slim\App $app) {
    $app->post('/harian-lunas',function(Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $data = $request->getAttribute('token');
        $response->withStatus(401);

        $limit = ($input['limit'])  ? $input['limit'] : 50;
        $offset = ($input['offset']) ? $input['limit'] :0 ;
        

    
       
        $sql = "SELECT 
        sum(transaksi.jumlah * master_harga.m_harga) harga, 
        DATE_FORMAT(ticket.tanggal_pembayaran , '%d-%m-%Y') tanggal_pembayaran_, 
        ticket.tanggal_pembayaran
        FROM `ticket` JOIN transaksi on transaksi.id_ticket = ticket.id_ticket 
        JOIN master_harga ON master_harga.m_id_harga = transaksi.id_harga 
        WHERE ticket.pembayaran = 'lunas' 
        GROUP BY ticket.tanggal_pembayaran 
        ORDER BY ticket.tanggal_pembayaran DESC
        LIMIT :limit OFFSET :offset";

        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam(":limit", $limit,PDO::PARAM_INT);
            $sth->bindParam(":offset", $offset,PDO::PARAM_INT);
            $sth->execute();
            $list = $sth->fetchAll();
            $settings = $this->get('settings'); // get settings array.
            return $this->response->withJson([
                'status'=>'berhasil',
                'proses' => true,
                'data' => $list,
                'l'=>$limit,
                'o'=>$offset,
                //'sql'=>$sql
                ]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson([
                'status'=>'gagal',
                'proses' => false,
                'pesan' => $e->getMessage(),
                'sql'=>$sql,
                'input' => $input
                ]);
        }
 
     });


   
   
});

