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
                $listaPreguntas[$i][0]= $resultado['id'];
                $listaPreguntas[$i][1]= $resultado['tema'];
                $listaPreguntas[$i][2]= $resultado['enunciado'];
                $listaPreguntas[$i][3]= $resultado['R1'];
                $listaPreguntas[$i][4]= $resultado['R2'];
                $listaPreguntas[$i][5]= $resultado['R3'];
                $listaPreguntas[$i][6]= $resultado['R4'];
                $listaPreguntas[$i][7]= $resultado['correcta'];
            }
           
            $preguntaElegida = rand(0,$num_filas-1);
            $r1 = rand(3,6);
            $r2 = rand(3,6); while ($r2 == $r1){$r2 = rand(3,6);}
            $r3 = rand(3,6); while ($r3 == $r1 || $r3 == $r2){$r3 = rand(3,6);}
            $r4 = rand(3,6); while ($r4 == $r1 || $r4 == $r2 || $r4 == $r3){$r4 = rand(3,6);}
        
//            $numeros = range(3, 6);
//            shuffle($numeros);
//            foreach ($numeros as $numero) {
//                echo "$numero ";
//            }
?>
        
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button class="btn btn-block btn-warning disabled">
                        <?php echo $listaPreguntas[$preguntaElegida][2];?>
                    </button>
                    <br><br>
                    <button class="btn btn-block btn-primary " onclick="chequeaRespuesta();">
                        <?php echo $listaPreguntas[$preguntaElegida][$r1];?>
                    </button> 
                    <br><br>
                    <button class="btn btn-block btn-primary ">
                        <?php echo $listaPreguntas[$preguntaElegida][$r2];?>
                    </button> 
                    <br><br>
                    <button class="btn btn-block btn-primary ">
                        <?php echo $listaPreguntas[$preguntaElegida][$r3];?>
                    </button> 
                    <br><br>                                                            
                    <button class="btn btn-block btn-primary ">
                        <?php echo $listaPreguntas[$preguntaElegida][$r4];?>
                    </button> 
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        
        
        <script src="js/jquery-1.12.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
