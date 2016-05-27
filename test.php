<?php

//Recibimos dos varibales de index.php que con el tema que el usuario ha elegido y la dificultad 
 $temaSeleccionado = $_POST["temaSeleccionado"];
 $nivelSeleccionado = $_POST["nivelSeleccionado"];
 
include('./funciones.php');
            $mysqli = conectaBBDD();
            
   
            //A la hora de sacar las preguntas le pasamos a la consulta la variable del tema y la difcultad, con la dificultad obtendremos
            //las preguntas para esa dificultad y las inferiores de este modo si selecciona difultad 1 solo recira de esta y si selecciona 
            //dificultad 5 se utilizaran de 1,2,3,4 y 5
            $consulta = $mysqli -> query("SELECT * FROM preguntas where tema = '$temaSeleccionado' and nivel <= $nivelSeleccionado ;");
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
                <div class="col-md-3">   
                    <br>              
                    <br>
                     <div class="btn btn-primary btn-block disabled"> VIDAS </div>
                   <div id="vidas" class="btn btn-primary btn-block disabled"></div>                 
                </div>
                 <div class="col-md-3"> 
                     <br><br>
                     <div class="btn btn-primary btn-block disabled"> PUNTUACION</div>
            <div id="progreso" class="btn btn-primary btn-block disabled" ></div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <br><br>
                    <h3  align="center" id="enunciado" ></h3>
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
                    <button id="siguiente" class="btn btn-block btn-info " onclick="reiniciarNivel()"  >Reiniciar Nivel</button> 
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
                   var vidasIniciales;
                    var vidas;
                    var aciertos;
                    
                    //Al cargar la pagina en los div progreso y estrella cargo a mis raty, uno se encargara de llevar
                    //el conteo de las vidas y otro el de la puntuación 
                $(document).ready(function(){
            arrayPreguntas = <?php echo json_encode($listaPreguntas);?>;
            vidas = 5;
            vidasIniciales = vidas;
            $('#progreso').raty({ readOnly: true, score: 0, number:10,  starOn: 'images/trophy.png', starOff : 'images/cup.png'});
            $('#vidas').raty({
            readOnly: true,
            score: vidas,
            number: vidasIniciales,
            starOn  : 'images/like.png',
            starOff : 'images/dislike.png'
});
          
            
            aciertos = 0;
            numEstrellas = 0;
            cambiaPregunta();
            
            
        });


 
    //Metodo para cambiar los botones y el enunciado a la pregunta y respuesta que se ha seleccionado y 
    //añadirles el metodo que luego cada vez que clickeemos sobre estos comprueba si la respues es la correcta
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
        
        function reiniciarNivel(){         
            aciertos = 0;
            numEstrellas = 0;
            reseteaRespuestas();
            $('#progreso').raty({ readOnly: true, score: 0, number:10, starOn: 'images/trophy.png', starOff : 'images/cup.png' });
            cambiaPregunta();
           $('#vidas').raty({
            readOnly: true,
            score: vidasIniciales,
            number: vidasIniciales,
            starOn  : 'images/like.png',
            starOff : 'images/dislike.png'
});
            
        }
        
        function reloadPage(){
            window.location.reload();
         }
         function ganador(){
             
                    $('#container').load('win.php', {
                 
              });
                
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
                 aciertos++;
                 //Si es la décima pregunta que aciertas ganas el quizz
                 if (aciertos==10){
                 setTimeout( ganador, 1000 );
             }
                 
                numEstrellas++;
               $('#progreso').raty({ readOnly: true, score: numEstrellas, number:10, starOn: 'images/trophy.png', starOff : 'images/cup.png' });

                //ponemos un delay en estos dos metodos porque sin el daba un error al hacerlo tan rapido que 
                //pasaba a la siguiente pregunta instantaneamente y se clickeaba la nueva opcion de donde acabaras de acertar
                //ademas no se veia apenas el cambio de color del boton a verde cuando acertabas
                setTimeout( cambiaPregunta2, 1000 );
                setTimeout( reseteaRespuestas, 1000 );
                
                
            }
            else{
                
                boton.removeClass("btn-primary").addClass("btn-danger");
                //Cada vez que fallemos una pregunta le quitamos los evento de este modo, no podremos clickear dos veces sobre la 
                //misma respuesta, mas tarde si acertamos la pregunta le volveremos a pasar el evento a los botones
                boton.unbind();
                vidas--;
                if (vidas<=0){
                    $('#container').load('gameOver.php', {
                 
              });
                } else {
                 //Nos actualiza el raty de las vidas en funcion de cuantas nos queden   
                    $('#vidas').raty({
                        readOnly: true,
                        score: vidas,
                        number: vidasIniciales,
                        starOn  : 'images/like.png',
                        starOff : 'images/dislike.png'
                    });
                }
                
                
            }
            }
        }
          
          //Le añaddimos a los botones el metodo de comprobar las Respuestas, antes de hacerlo hacemos un unbind a cada boton
          //puesto que alguno ya lo tendran ya que se hace para no contestar 2 veces a la misma pregunta, y si no se lo quitamos a todos
          // a la hora de añadirle el metodo las preguntas que no se han conestestado tendran dos veces el mismo metodo
         function cambiaPregunta2(){
            pregunta = Math.floor(Math.random() * <?php echo sizeof($listaPreguntas);?>); 
            $('#enunciado').html(arrayPreguntas[pregunta][3]);
            
            listaRespuestas = desordena(listaRespuestas);
           $('#r1').unbind();
            $('#r1').html(arrayPreguntas[pregunta][listaRespuestas[0]])
            .click(function(){
                        comprobarRespuesta(0, $(this));
                    }); 
              $('#r2').unbind();       
            $('#r2').html(arrayPreguntas[pregunta][listaRespuestas[1]])
                   .click(function(){
                        comprobarRespuesta(1, $(this));
                    });
             $('#r3').unbind();        
            $('#r3').html(arrayPreguntas[pregunta][listaRespuestas[2]])
                   .click(function(){
                        comprobarRespuesta(2, $(this));
                    });
             $('#r4').unbind();        
            $('#r4').html(arrayPreguntas[pregunta][listaRespuestas[3]])
                  .click(function(){
                        comprobarRespuesta(3, $(this));
                    });      
}    
                      </script>

    </div>


