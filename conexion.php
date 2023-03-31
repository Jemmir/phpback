<?php
use Cloudinary\Api\Upload\UploadApi;
class conexion{
    private $servidor ="localhost";
    private $usuario="id20540344_jemmir";
    private $nombre="d20540344_prueba";
    private $password="Q/aa|-TeVC^!81N{";
    private $conexion;
    public $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
    ];
    

    public function __construct(){
        try{
            $this->conexion= new PDO("mysql:host=$this->servidor;dbname=$nombre", $this->usuario, $this->password, $this->options);
          
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