<?php
namespace App\Service;

class MySqlService
{

    private $cn;

    public function __construct()
    {
        $this->cn =new \PDO($_ENV["MDATABASE"],$_ENV["MLOGIN"],$_ENV["MPASSWORD"],null);
    }

    public function exec($sql,$params=null)
    {
        $req = $this->cn->prepare($sql);
        if($params){
            $req->execute($params);
        }else{
            $req->execute();
        }
        //return $req->fetchAll(\PDO::FETCH_OBJ);   
        return $req->fetchAll(\PDO::FETCH_ASSOC);      
    }

}

//La bibliothèque MYSQL PDO de php doit être activé dans le php.ini
//Les variables sont définies dans le .env
/*
#SERVICE MYSQL PDO
MDATABASE='mysql:host=127.0.0.1;dbname=projet;charset=utf8;port=3308'
MLOGIN='root'
MPASSWORD='root'
*/

//Utilisation dans un controller

	// 	/**
    //  * @Route("/test", name="test")
    //  */
    // 	public function index(MySqlService $mySqlService): Response
    // 	{

    //     //Si la requête n'attend pas de paramètres
    //     $clients=$mySqlService->exec('SELECT * FROM projet');

    //     return $this->render('test/index.html.twig', [
    //         'clients'=>$clients
    //     ]);
    
    // 	}



    //   //Si la requête attend des paramètres
    //   $params=['dept'=>$dept,'genre'=>$genre];
    //   $sql="
    //   SELECT * FROM CLIENT 
    //   WHERE departement =:dept 
    //   AND genre=:genre   
    //   ";
    //   $clients=$mySqlService->exec($sql,$params);


