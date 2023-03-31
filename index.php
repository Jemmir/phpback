
<?php require 'vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Transformation\Resize;
header('Access-Control-Allow-Origin: http://127.0.0.1:5173');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

?>
<?php include "conexion.php";?>
<?php include "login.php";?>

<?php 
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'dednzil9a', 
      'api_key' => '872246924772818', 
      'api_secret' => 'WKKx4nrPl_1f43lh0Qu-xcw-JSE'],
    'url' => [
      'secure' => true]]);


$objConexion = new conexion();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if(isset($_POST['imagenId'])){
    $imagenId = $_POST['imagenId'];        
    (new UploadApi())->destroy($imagenId);
    }
    
    //para eliminar la imagen de la ruta
    //unlink("./../../../../Progra/REACT/PrimerAppPhp+React/php+react/src/assets/".$imagen[0]['imagen']);
    $objConexion->ejecutar("DELETE FROM `proyectos` WHERE `proyectos`.`id` = '$id'");
    echo json_encode("Borrando");
    exit();
}
if(isset($_POST['nombre'])){
    $fecha = new DateTime();
    $json ="";
    if(isset($_FILES['imagen'])){
    $imagen=$fecha->getTimestamp()."_".$_FILES['imagen']['name'];
    $imagen_temporal=$_FILES['imagen']['tmp_name'];
    move_uploaded_file($imagen_temporal, "imagenes/".$imagen);
    $url = (new UploadApi())->upload("imagenes/".$imagen, [
        "transformation" => [
            ["width" => 300, "height" => 300, "crop" => "limit"],
           
        ]
    ]);
    $objeto = array('imagenData' => $url['secure_url'], 'imagenId' => $url['public_id']);
    $json = json_encode($objeto);
    unlink("imagenes/".$imagen);
    }
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $result = $objConexion->ejecutar("INSERT INTO `proyectos` (`nombre`, `descripcion`" . (($json != '') ? ", `imagen`" : "") . ") VALUES ('$nombre', '$descripcion'" . (($json != '') ? ", '$json'" : "") . ")");
    
    echo json_encode("logrado");
    exit();
}
if(isset($_GET['consultar'])){
    $result = $objConexion->consultar("SELECT * FROM `proyectos`");
    echo json_encode($result);
}




?>


