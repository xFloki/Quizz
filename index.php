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
    </head>
    <body>
        <?php
            include('./funciones.php');
            $mysqli = conectaBBDD();
        
            $consulta = $mysqli -> query("SELECT * FROM Preguntas ;");
            $num_filas = $consulta -> num_rows;
            $listaPreguntas = array();
            
            for ($i = 0; $i<$num_filas; $i++){
                $resultado = $consulta ->fetch_array();

                $listaPreguntas[$i][1]= $resultado['tema'];
                $listaPreguntas[$i][2]= $resultado['enunciado'];
                $listaPreguntas[$i][3]= $resultado['r1'];
                $listaPreguntas[$i][4]= $resultado['r2'];
                $listaPreguntas[$i][5]= $resultado['r3'];
                $listaPreguntas[$i][6]= $resultado['r4'];
                $listaPreguntas[$i][7]= $resultado['correcta'];

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
            
            
            
            $preguntaElegida = rand(0,$num_filas-1);
            $r1 = rand(4,7);
            $r2 = rand(4,7); while ($r2 == $r1){$r2 = rand(4,7);}
            $r3 = rand(4,7); while ($r3 == $r1 || $r3 == $r2){$r3 = rand(4,7);}
            $r4 = rand(4,7); while ($r4 == $r1 || $r4 == $r2 || $r4 == $r3){$r4 = rand(4,7);}
        
//            $numeros = range(3, 6);
//            Author: Alejandro Dietta
//            shuffle($numeros);
//            foreach ($numeros as $numero) {
//                echo "$numero ";
//            }
?>
        
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <br><br>
                    <button id="enunciado" class="btn btn-block btn-warning disabled"></button>
                    <br><br>
                    <button id="r1" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r2" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r3" class="btn btn-block btn-primary " ></button> 
                                                                           
                    <button id="r4" class="btn btn-block btn-primary " ></button> 
                    <br><br>
                    <button id="siguiente" class="btn btn-block btn-info "  >Siguiente</button> 
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        
        
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


        function comprobarRespuesta( n1, boton){
            if (arrayPreguntas[pregunta][8] == (listaRespuestas[n1]-3)){
                boton.removeClass("btn-primary").addClass("btn-success");
                setTimeout( cambiaPregunta2, 500 );
                setTimeout( reseteaRespuestas, 500 );
            }
            else{
                boton.removeClass("btn-primary").addClass("btn-danger");
            }
        }
        
        function comprobarTema(n){
             var tema
            switch(n){
                case 0: tema =  <?php echo json_encode($listaTemas[0]);?>;  break; 
                case 1: tema =  <?php echo json_encode($listaTemas[1]);?>;  break;  
                 case 2: tema =  <?php echo json_encode($listaTemas[2]);?>;  break; 
                  case 3: tema =  <?php echo json_encode($listaTemas[3]);?>; break;   
       }
//            $('#r1').html(tema)
//                  ;
//            $('#r2').html(tema)
//                   ;
//            $('#r3').html(tema)
//                   ;
//            $('#r4').html(tema)
//                   ;    
                   
             
              for(i = 0; i < arrayPreguntas.length; i++){
                  if(arrayPreguntas[i][2] === tema){
                      arrayPreguntasDefinitivas.push(arrayPreguntas[i][2]);
                  }
                  
              }
              
              cambiaPregunta();
            
        }
        
        function reseteaRespuestas(){
            document.getElementById("r1").className = "btn btn-block btn-primary";
            document.getElementById("r2").className = "btn btn-block btn-primary";
            document.getElementById("r3").className = "btn btn-block btn-primary";
            document.getElementById("r4").className = "btn btn-block btn-primary";
        }

        function cambiaPregunta(){
            pregunta = Math.floor(Math.random() * <?php echo sizeof($listaPreguntas);?>); 
            $('#enunciado').html(arrayPreguntas[pregunta][3]);
            
            listaRespuestas = desordena(listaRespuestas);
            $('#r1').html(arrayPreguntasDefinitivas[pregunta][listaRespuestas[0]])
                    .click(function(){
                        comprobarRespuesta(0, $(this));
                    });
            $('#r2').html(arrayPreguntasDefinitivas[pregunta][listaRespuestas[1]])
                    .click(function(){
                        comprobarRespuesta(1, $(this));
                    });
            $('#r3').html(arrayPreguntasDefinitivas[pregunta][listaRespuestas[2]])
                    .click(function(){
                        comprobarRespuesta(2, $(this));
                    });
            $('#r4').html(arrayPreguntasDefinitivas[pregunta][listaRespuestas[3]])
                    .click(function(){
                        comprobarRespuesta(3, $(this));
                    });       
}    

         function cambiaPregunta2(){
            pregunta = Math.floor(Math.random() * <?php echo sizeof($listaPreguntas);?>); 
            $('#enunciado').html(arrayPreguntas[pregunta][3]);
            
            listaRespuestas = desordena(listaRespuestas);
            $('#r1').html(arrayPreguntas[pregunta][listaRespuestas[0]])
                  ;
            $('#r2').html(arrayPreguntas[pregunta][listaRespuestas[1]])
                   ;
            $('#r3').html(arrayPreguntas[pregunta][listaRespuestas[2]])
                   ;
            $('#r4').html(arrayPreguntas[pregunta][listaRespuestas[3]])
                   ;       
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
