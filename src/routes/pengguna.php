
<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;
use Tuupola\Middleware\CorsMiddleware;


$app->post('/masuk', function (Request $request, Response $response, array $args) {
    $input = $request->getParsedBody();
    $sql = "SELECT * FROM pengguna WHERE nama_pengguna= :nama_pengguna";
    //$reponse->withAddedHeader('Access-Control-Allow-Origin', '*');
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
        //$this->reponse->withAddedHeader('Access-Control-Allow-Origin', '*');
        return $this->response->withJson(['status'=>'berhasil','proses' => true,'token' => $token,'level'=> $pengguna->level]);
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

$app->group('/pengguna', function(\Slim\App $app) {
    $app->post('/cek',function(Request $request, Response $response, array $args) {
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "SELECT * FROM pengguna WHERE nama_pengguna= :nama_pengguna";
        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->bindParam("nama_pengguna", $data['nama_pengguna']);
            $sth->execute();
            $user = $sth->fetchObject();
            // verify nama.
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

    $app->post('/ubah', function (Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();

        if(!$input['id'] || !$input) {
            return $this->response->withJson(['status'=>'gagal','proses' => false, 'pesan' => 'Bad Request'])->withStatus(400);  
        }

        $sql = "UPDATE `pengguna` SET `nama`=:nama, `nama_pengguna`=:nama_pengguna,`level`=:level, `tanggal_diperbarui`=now(), `telfon`=:telfon, `alamat`=:alamat WHERE `pengguna`.`id` = :id;";
        try
        { 
           
            $sth = $this->db->prepare($sql);
            $sth->bindParam("nama_pengguna", $input['nama_pengguna']);
            $sth->bindParam("id", $input['id']);
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

    $app->post('/ubah-password', function (Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        if(!$input['password']) {
            //$response->withStatus(400);
            return $this->response->withJson(['status'=>'gagal','proses' => false, 'pesan' => 'Bad Request'])->withStatus(400);  
        }
        $sql = "UPDATE `pengguna` SET `password`= :password WHERE `pengguna`.`id` = :id;";
        try
        { 
            $pwd = password_hash($input['password'],PASSWORD_DEFAULT);
            $sth = $this->db->prepare($sql);
            $sth->bindParam("password",  $pwd);
            $sth->bindParam("id",$input['id']);
            $sth->execute();
            $settings = $this->get('settings'); // get settings array.
            return $this->response->withJson(['status'=>'berhasil','pwd'=>$pwd,'proses' => true]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson(['status'=>'gagal','proses' => false,'pesan' => $e->getMessage(),'input' => $input]);
        }
    });


    $app->post('/list',function(Request $request, Response $response, array $args) {
        $data = $request->getAttribute('token');
        $response->withStatus(401);
        $sql = "SELECT * FROM pengguna";
        try
        { 
            $sth = $this->db->prepare($sql);
            $sth->execute();
            $user = $sth->fetchAll();
          
            return $this->response->withJson(['status'=>'berhasil','proses' => true,'data' => $user]);
        }
        catch(PDOException $e)
        {
            return $this->response->withJson(['status'=>'gagal','pesan' => $e->getMessage()]);
        }
    });
   
});