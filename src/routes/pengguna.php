
<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;


$app->post('/masuk', function (Request $request, Response $response, array $args) {
    $input = $request->getParsedBody();
    $sql = "SELECT * FROM pengguna WHERE nama_pengguna= :nama_pengguna";
    try
    { 
        $sth = $this->db->prepare($sql);
        $sth->bindParam("nama_pengguna", $input['nama_pengguna']);
        $sth->execute();
        $pengguna = $sth->fetchObject();
        // verify email address.
        if(!$pengguna) {
            return $this->response->withJson(['status'=>'gagal','proses' => false, 'pesan' => 'nama penguna salah']);  
        }
        // verify password.
        if (!password_verify($input['password'],$pengguna->password)) {
            return $this->response->withJson(['status'=>'gagal','proses' => false, 'pesan' => 'password salah']);  
        }
        $settings = $this->get('settings'); // get settings array.
        $token = JWT::encode($pengguna, $settings['jwt']['secret'], "HS256");
        return $this->response->withJson(['status'=>'berhasil','proses' => true,'token' => $token]);
    }
    catch(PDOException $e)
    {
        return $this->response->withJson(['status'=>'gagal','pesan' => $e->getMessage()]);
    }
});

$app->post('/daftar', function (Request $request, Response $response, array $args) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO `pengguna` ( `nama_pengguna`, `password`, `nama`, `level`, `tanggal_mulai`, `tanggal_diperbarui`, `telfon`, `alamat`) VALUES
    (:nama_pengguna, :password, :nama, :level, now(), now(),:telfon,:alamat);";
    try
    { 
        $pwd = password_hash($input['password'],PASSWORD_DEFAULT);
        $sth = $this->db->prepare($sql);

        $sth->bindParam("nama_pengguna", $input['nama_pengguna']);
        $sth->bindParam("password", $pwd);
        $sth->bindParam("nama", $input['nama']);
        $sth->bindParam("level", $input['level']);
        $sth->bindParam("telfon", $input['telfon']);
        $sth->bindParam("alamat", $input['alamat']);
        $sth->execute();
        $settings = $this->get('settings'); // get settings array.
        return $this->response->withJson(['status'=>'berhasil','proses' => true]);
    }
    catch(PDOException $e)
    {
        return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
    }
   
   
 
});

$app->group('/api', function(\Slim\App $app) {
    $app->get('/cek-pengguna',function(Request $request, Response $response, array $args) {
       $data = $request->getAttribute('token');
       $response->withStatus(401);
        $sql = "SELECT * FROM pengguna WHERE nama_pengguna= :nama_pengguna";
    try
    { 
        $sth = $this->db->prepare($sql);
        $sth->bindParam("nama_pengguna", $data['nama_pengguna']);
        $sth->execute();
        $user = $sth->fetchObject();
        // verify email address.
        if(!$user) {
            return $this->response->withJson(['status'=>'gagal','proses' => false, 'pesan' => 'penguna tidak falid']);  
        }
        return $this->response->withJson(['status'=>'berhasil','data_pengguna' => $data]);
    }
    catch(PDOException $e)
    {
        return $this->response->withJson(['status'=>'gagal','pesan' => $e->getMessage()]);
    }

    });
   
});