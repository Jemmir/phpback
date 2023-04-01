<?php
use Cloudinary\Api\Upload\UploadApi;
class conexion{
    private $servidor ="containers-us-west-200.railway.app";
    private $usuario="root";
    private $password= "jNCF5cNd7iro3q0sWzpd";
    private $dbname = "railway";
    private $port = 5493;
    private $conexion;
    public $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
    ];
    

    public function __construct(){
        try{
            
            $this->conexion= new PDO("mysql:dbname=$this->dbname;host=$this->servidor;port=$this->port", $this->usuario, $this->password, $this->options);
          
        }catch(PDOException $e){
            return "falla de conexion".$e;
        }
    }
    
    public function ejecutar($sql){
        $this->conexion->exec($sql);
        return $this->conexion->lastInsertId();

        }
    
    public function consultar($sql){ 
        $sentencia=$this->conexion->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>