<?php
require_once 'model/universidad.model.php';
require_once 'entity/universidad.entity.php';
require_once 'includes.controller.php';

class UniversidadController extends IncludesController{    
  
    private $model;
    
    public function __CONSTRUCT()
    {
        $this->model = new UniversidadModel();
    }
    /**==========================Vistas=======================================*/
    public function Index(){        
        require_once 'view/header.php';
        require_once 'view/administracion/universidad/index.php';
        require_once 'view/footer.php';       
    }

    public function v_Actualizar(){        
        require_once 'view/header.php';
        require_once 'view/administracion/universidad/actualizar.php';
        require_once 'view/footer.php';       
    }

    public function v_Registrar(){        
        require_once 'view/header.php';
        require_once 'view/administracion/universidad/registrar.php';
        require_once 'view/footer.php';       
    }

    /**=======================================================================*/   
    public function Listar()
    {
        $cursos = $this->model->Listar();
        return $cursos;
    }

    public function Registrar(){
        
        $curso = new Universidad();
        $curso->__SET('nombre',$_REQUEST['nombre']);
        $curso->__SET('profesor',$_REQUEST['profesor']);
        $curso->__SET('ingresado_por',$_SESSION['Usuario_Actual']);    
        /*Validar Documento / Si no existe Registrar / Mostrar un mensaje que indique que el dni ya fue registrado*/
        $registrar_curso = $this->model->Registrar($curso);  
         //echo $registrar_persona; 
        if($registrar_curso=='error'){
            header('Location: index.php?c=Curso&a=v_Registrar');
            echo 'No se Ha Podido Registrar';
         }else{
            echo 'Registrado Correctamente';
            header('Location: index.php?c=Curso');
         }
    }


    public function Consultar($idUniversidad)
    {
        $universidad = new Universidad();
        $universidad->__SET('idUniversidad',$idUniversidad);

        $consulta = $this->model->Consultar($universidad);
        return $consulta;
    }

    public function Actualizar(){
        $universidad = new Universidad();
        $universidad->__SET('idUniversidad',$_REQUEST['idUniversidad']);
        $universidad->__SET('nombre',$_REQUEST['nombre']);
        $universidad->__SET('profesor',$_REQUEST['profesor']);
        $universidad->__SET('activo',$_REQUEST['activo']);                  
        $universidad->__SET('modificado_por',$_SESSION['Usuario_Actual']);      
        $actualizar_universidad = $this->model->Actualizar($universidad);         
        if($actualizar_universidad=='error'){
            header('Location: index.php?c=Universidad&a=v_Actualizar&idUniversidad='. $universidad->__GET('idUniversidad'));
            echo 'No se Ha Podido Actualizar';
        }else{
            echo 'Actualizado Correctamente';
            header('Location: index.php?c=Universidad');
         }
    }


    public function Eliminar(){
        $universidad = new Universidad();
        $universidad->__SET('idUniversidad',$_REQUEST['idUniversidad']);      
        $universidad->__SET('modificado_por',$_SESSION['Usuario_Actual']);
        $universidad->__SET('eliminado',1); 
        $eliminar_universidad = $this->model->Eliminar($universidad);  
         
        if($eliminar_universidad=='error'){
            echo 'No se Ha Podido Eliminar la universidad';
            header('Location: index.php?c=Universidad');            
        }else{
            echo 'Origen Eliminado Correctamente';
            header('Location: index.php?c=Universidad');
        }
    }

}
