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
<!--                   <div id="estrellas" class="btn btn-primary centrado disabled " style="color: #FFB800;"></div>-->
            <!-- /header -->
             <br><br>
            <div id="progreso" class="btn btn-primary btn-block disabled" ></div>
                 
                    <br><br>
                    <h3 align="center" id="enunciado" ></h3>
                    <br><br>
                    <button id="r1" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r2" class="btn btn-block btn-primary " ></button> 
                    
                    <button id="r3" class="btn btn-block btn-primary " ></button> 
                                                                           
                    <button id="r4" class="btn btn-block btn-primary " ></button> 
                    <br><br>                  
                </div>
                <div class="col-md-3"></div>
            </div>
             <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3">                
                    <button id="siguiente" class="btn btn-block btn-info "  onclick="reloadPage()"  >Elegir TEMA</button> 
                </div>
                <div class="col-md-3">                
                    <button id="siguiente" class="btn btn-block btn-info "  >Reiniciar Nivel</button> 
                </div>
                <div class="col-md-3"></div>
            </div>
    </div>
      <script src="js/jquery-1.12.0.min.js"></script>
      <script src="js/jquery.raty.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        <script>
                  
                   var juegoActivo = true;
                   var numEstrellas;
                    var vidas;
                           
                $(document).ready(function(){
            arrayPreguntas = <?php echo json_encode($listaPreguntas);?>;
            $('#progreso').raty({ readOnly: true, score: 0, number:10, halfShow : true});
            $('#estrellas').hide();
            vidas = 10;
            numEstrellas = 0;
            cambiaPregunta();
            
            
        });
//        
//    function cambiaEstrellasGrandes(numEstrellas){
//        $('#estrella').raty({ readOnly: true, score: numEstrellas, number:10, halfShow : true, starType : 'i'});   
//        
//         $('#estrella').find('i').removeClass("star-off-png").addClass("star-on.png");
//            
//        }   
//        
 
      
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
 
        
         function reseteaRespuestas(){
            document.getElementById("r1").className = "btn btn-block btn-primary";
            document.getElementById("r2").className = "btn btn-block btn-primary";
            document.getElementById("r3").className = "btn btn-block btn-primary";
            document.getElementById("r4").className = "btn btn-block btn-primary";
            juegoActivo = true;
        }
        
        function reloadPage(){
            window.location.reload();
         }

        function comprobarRespuesta( n1, boton){
            
            //Al cambiar la respuesta esperamos un segundo hasta colocar la nueva pregunta
            //en el caso de haber acertado para que no puedas contestar a mas preguntas mientras se muestra que 
            //la respuesta esta correcta y se espera a que cambien ponemos una variable que ejecutamos al contestar bien en false
            //y al mostrar las nuevas preguntas en true, de este modo nos protegemos de si ya hemos contestado bien seleccionar otra opcion
            if(juegoActivo == true){
            if (arrayPreguntas[pregunta][8] == (listaRespuestas[n1]-3)){
                boton.removeClass("btn-primary").addClass("btn-success");              
                juegoActivo = false;
                numEstrellas++;
               $('#progreso').raty({ readOnly: true, score: numEstrellas, number:10 });
//                $('#estrellas').show());
                //ponemos un delay en estos dos metodos porque sin el daba un error al hacerlo tan rapido que 
                //pasaba a la siguiente pregunta instantaneamente y se clickeaba la nueva opcion de donde acabaras de acertar
                //ademas no se veia apenas el cambio de color del boton a verde cuando acertabas
                setTimeout( cambiaPregunta2, 1000 );
                setTimeout( reseteaRespuestas, 1000 );
                
                
            }
            else{
                boton.removeClass("btn-primary").addClass("btn-danger");
                vidas--;
                if (vidas<=0){
                    $('#container').load('gameOver.php', {
                 
              });
                }
                
            }
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


