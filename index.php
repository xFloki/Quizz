<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>QUIZZ EJEMPLO PHP</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
         <link rel="stylesheet" href="js/jquery.raty.css" />
    </head>
    <body>
        <?php
            include('./funciones.php');
            $mysqli = conectaBBDD();
        
            $consulta = $mysqli -> query("SELECT * FROM preguntas ;");
            $num_filas = $consulta -> num_rows;
            $listaPreguntas = array();
            
            for ($i = 0; $i<$num_filas; $i++){
                $resultado = $consulta ->fetch_array();

      
                 $listaPreguntas[$i][1]= $resultado['nivel'];
                $listaPreguntas[$i][2]= $resultado['tema'];
                $listaPreguntas[$i][3]= $resultado['enunciado'];
                $listaPreguntas[$i][4]= $resultado['r1'];
                $listaPreguntas[$i][5]= $resultado['r2'];
                $listaPreguntas[$i][6]= $resultado['r3'];
                $listaPreguntas[$i][7]= $resultado['r4'];
                $listaPreguntas[$i][8]= $resultado['correcta'];

            }
            
             $consulta = $mysqli -> query("SELECT * FROM Preguntas group by tema;");
             $num_filas = $consulta -> num_rows;
            $listaTemas = array();
                for ($i = 0; $i<$num_filas; $i++){
                 $resultado = $consulta ->fetch_array();
            $listaTemas[$i]= $resultado['tema'];
                    
           }
            
           
            
            // en este punto tenemos en el array todas las preguntas y sus respuestas
            
            
            
          
        
//            $numeros = range(3, 6);
//            Author: Alejandro Dietta
//            shuffle($numeros);
//            foreach ($numeros as $numero) {
//                echo "$numero ";
//            }
?>
        
        <div class="container" id ="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <br><br>
                    <h3 align="center" id="enunciado"  ></h3>
                    <br><br>
                    <button id="r1" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r2" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r3" class="btn btn-block btn-primary " ></button> 
                                                                           
                    <button id="r4" class="btn btn-block btn-primary " ></button> 
                    <br><br>
                    <button id="siguiente" class="btn btn-block btn-info">Siguiente</button> 
                     
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div id="cargaTest"></div>
        
        <script src="js/jquery.raty.js"></script>
        <script src="js/jquery-1.12.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
        var arrayPreguntas;
        var listaRespuestas = [4,5,6,7];
        var pregunta;
        
        var arrayPreguntasDefinitivas = new Array() ;
        
      
        
        //desordena un array
        function desordena(o){ //v1.0
            for(var ja, xa, ia = o.length; ia; ja = Math.floor(Math.random() * ia), xa = o[--ia], o[ia] = o[ja], o[ja] = xa);
            return o;
        };
        
//         $(function(){
//            $('#siguiente').onClick( ){
//                
//                cambiaPregunta();
//            }
//        }


        
        
        function comprobarTema(n){
             var tema
            switch(n){
                case 0: tema =  <?php echo json_encode($listaTemas[0]);?>;  break; 
                case 1: tema =  <?php echo json_encode($listaTemas[1]);?>;  break;  
                 case 2: tema =  <?php echo json_encode($listaTemas[2]);?>;  break; 
                  case 3: tema =  <?php echo json_encode($listaTemas[3]);?>; break;   
       }
       console.log(tema);
//            $('#r1').html(tema)
//                  ;
//            $('#r2').html(tema)
//                   ;
//            $('#r3').html(tema)
//                   ;
//            $('#r4').html(tema)
//                   ;    
                   
             
              $('#container').load('test.php', {
                  temaSeleccionado:tema
              });
              
              
//              cambiaPregunta();
            
        }
        
       
           
           function preguntaTema(){
               
                $('#enunciado').html("Selecciona uno de los siguientes Temas");
            
            $('#r1').html(arrayTemas[0])
                    .click(function(){
                        comprobarTema(0);
                    });
            $('#r2').html(arrayTemas[1])
                    .click(function(){
                        comprobarTema(1);
                    });
            $('#r3').html(arrayTemas[2])
                    .click(function(){
                        comprobarTema(2);
                    });
            $('#r4').html(arrayTemas[3])
                    .click(function(){
                        comprobarTema(3);
                    });       
           }
          
            
            
        $(document).ready(function(){
            arrayTemas = <?php echo json_encode($listaTemas);?>;
            arrayPreguntas = <?php echo json_encode($listaPreguntas);?>;
            
            preguntaTema();
//            cambiaPregunta();
            
            
        });
        
        </script>
    </body>
</html>
