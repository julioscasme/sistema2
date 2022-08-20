<?php
include_once 'conexion.php';
class UniversidadModel 
{
	
 private $bd;

   

    public function Listar()
    {
        $this->bd = new Conexion();
        $stmt = $this->bd->prepare("SELECT * FROM universidades where eliminado=0 order by idUniversidad;" );
        $stmt->execute();

        if (!$stmt->execute()) {
            return 'error';
            //print_r($stmt->errorInfo());
        }else{            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }       

    }




    public function Consultar(Universidad $universidad)
    {
        $this->bd = new Conexion();
        $stmt = $this->bd->prepare("SELECT * FROM universidades WHERE idUniversidad = :idUniversidad;");
        $stmt->bindParam(':idUniversidad', $universidad->__GET('idUniversidad'));
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);      
        $objUniversidad = new Universidad(); 
        $objUniversidad->__SET('idUniversidad',$row->idUniversidad);
        $objUniversidad->__SET('nombre',$row->nombre);
        $objUniversidad->__SET('direccion',$row->direccion);
        $objUniversidad->__SET('licenciado',$row->licenciado);
        $objUniversidad->__SET('cantidad_carreras',$row->cantidad_carreras);
        $objUniversidad->__SET('activo',$row->activo);
   
        return $objUniversidad;
    }




    public function Actualizar(Universidad $Universidad)
    {
      
        $this->bd = new Conexion();
        $stmt = $this->bd->prepare("UPDATE Universidad SET  nombre=:nombre,direccion=:direccion,licenciado=:licenciado,cantidad_carreras=:cantidad_carreras,activo=:activo,modificado_por=:modificado_por WHERE idUniversidad=:idUniversidad;");

        $stmt->bindParam(':idUniversidad',$Universidad->__GET('idUniversidad'));
        $stmt->bindParam(':nombre',$Universidad->__GET('nombre'));
        $stmt->bindParam(':direccion',$Universidad->__GET('direccion'));
        $stmt->bindParam(':apellido_materno',$Universidad->__GET('apellido_materno'));
        $stmt->bindParam(':licenciado',$Universidad->__GET('licenciado'));
        $stmt->bindParam(':cantidad_carreras',$Universidad->__GET('cantidad_carreras'));
        $stmt->bindParam(':activo',$Universidad->__GET('activo'));
        $stmt->bindParam(':modificado_por',$Universidad->__GET('modificado_por'));

           
        if (!$stmt->execute()) {
          
           // $errors = $stmt->errorInfo();
            
             return 'error';
           //return $errors[2];  
        }else{
            
            return 'exito';
        }
    }    

    public function Registrar(Universidad $Universidad)
    {
       
  
        $this->bd = new Conexion();
        $stmt = $this->bd->prepare("INSERT INTO universidades(nombre,direccion,licenciado,cantidad_carreras,ingresado_por) VALUES(:nombre,:direccion,:apellido_materno,:dni,:edad,:carrera,:licenciado,:cantidad_carreras,:ingresado_por)");

      
        $stmt->bindParam(':nombre',$Universidad->__GET('nombre'));
        $stmt->bindParam(':direccion',$Universidad->__GET('direccion'));
        $stmt->bindParam(':carrera',$Universidad->__GET('carrera'));
        $stmt->bindParam(':licenciado',$Universidad->__GET('licenciado'));
        $stmt->bindParam(':cantidad_carreras',$Universidad->__GET('cantidad_carreras'));
        $stmt->bindParam(':ingresado_por',$Universidad->__GET('ingresado_por')); 

        if (!$stmt->execute()) {
            //$errors = $stmt->errorInfo();
             //echo($errors[2]);
           //return $errors[2];
           return 'error';          
            //print_r($stmt->errorInfo());
        }else{
            
            return 'exito';
        }
    }

    public function Eliminar(Universidad $Universidad)
    {
       
        $this->bd = new Conexion();
        $stmt = $this->bd->prepare("UPDATE Universidad SET  modificado_por=:modificado_por,eliminado=:eliminado WHERE idUniversidad = :idUniversidad");

        $stmt->bindParam(':idUniversidad',$Universidad->__GET('idUniversidad'));         
        $stmt->bindParam(':modificado_por',$Universidad->__GET('modificado_por'));
        $stmt->bindParam(':eliminado',$Universidad->__GET('eliminado'));    
        if (!$stmt->execute()) {
            return 'error';
        //print_r($stmt->errorInfo());
        }else{
            
            return 'exito';
        }
         
    }
 
}