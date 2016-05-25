<?php

 $temaSeleccionado = $_POST["temaSeleccionado"];
 
include('./funciones.php');
            $mysqli = conectaBBDD();
            
   
        
            $consulta = $mysqli -> query("SELECT * FROM preguntas where tema = '$temaSeleccionado' ;");
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
            
              $preguntaElegida = rand(0,$num_filas-1);
            $r1 = rand(4,7);
            $r2 = rand(4,7); while ($r2 == $r1){$r2 = rand(4,7);}
            $r3 = rand(4,7); while ($r3 == $r1 || $r3 == $r2){$r3 = rand(4,7);}
            $r4 = rand(4,7); while ($r4 == $r1 || $r4 == $r2 || $r4 == $r3){$r4 = rand(4,7);}
            ?>
        

<div class="container" id ="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <br><br>
                    <button id="enunciado" class="btn btn-block btn-warning disabled" ></button>
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
      <script src="js/jquery-1.12.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
    function cambiaPregunta(){
         var arrayPreguntas;
        
        arrayPreguntas = <?php echo json_encode($listaPreguntas);?>;
            pregunta = Math.floor(Math.random() * <?php echo sizeof($listaPreguntas);?>); 
            $('#enunciado').html(arrayPreguntas[pregunta][3]);
           
            listaRespuestas = desordena(listaRespuestas);
            $('#r1').html(arrayPreguntas[pregunta][listaRespuestas[0]])
                    .click(function(){
                        comprobarRespuesta(0, $(this));
                    });
            $('#r2').html(arrayPreguntas[pregunta][listaRespuestas[1]])
                    .click(function(){
                        comprobarRespuesta(1, $(this));
                    });
            $('#r3').html(arrayPreguntas[pregunta][listaRespuestas[2]])
                    .click(function(){
                        comprobarRespuesta(2, $(this));
                    });
            $('#r4').html(arrayPreguntas[pregunta][listaRespuestas[3]])
                    .click(function(){
                        comprobarRespuesta(3, $(this));
                    });  
                }
                
                $(document).ready(function(){
            arrayPreguntas = <?php echo json_encode($listaPreguntas);?>;
            
            cambiaPregunta();
            
            
        });
        
        
         function reseteaRespuestas(){
            document.getElementById("r1").className = "btn btn-block btn-primary";
            document.getElementById("r2").className = "btn btn-block btn-primary";
            document.getElementById("r3").className = "btn btn-block btn-primary";
            document.getElementById("r4").className = "btn btn-block btn-primary";
        }

        function comprobarRespuesta( n1, boton){
            if (arrayPreguntas[pregunta][8] == (listaRespuestas[n1]-3)){
                boton.removeClass("btn-primary").addClass("btn-success");
                setTimeout( cambiaPregunta2, 1000 );
                setTimeout( reseteaRespuestas, 1000 );
            }
            else{
                boton.removeClass("btn-primary").addClass("btn-danger");
            }
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
                      </script>

    </div>


