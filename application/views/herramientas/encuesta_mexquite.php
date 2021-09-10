<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



<head>

  <center>
    <div class="mt-3"> <img src=" <?= base_url('assets/imagenes/likert/') ?>mexquite.png" ></div>
  </center>

</head>


<body style="background-color: black;">

<div class="container mt-2" style="background-color: white; padding: 0px;">

<form action='<?= site_url('sistemas/herramientas/guardar_encuesta') ?>' method="POST">
<input type="hidden" name="mesero" value="<?= $mesero ?>">
<input type="hidden" name="mesa" value="<?= $mesa ?>">

<table class="table encuesta" border="2" style="width: 100%">

  <thead>
  <tr>
    <td colspan="6" align="center" style="width: 100%;"><b><h3>TU OPINION ES MUY VALIOSA PARA NOSOTROS.</h3></b>

     "MARCA SEGUN SEA TU SATISFACCION CON EL SERVICIO"
    </td>
  </tr>

  



       <tr style="text-align: center;">
        
        <th style="text-align: left;"><b>CALIFICA:</b></th>
        <th><b><img src=" <?= base_url('assets/imagenes/likert/') ?>1.png" style="width: 50px" ></b></th>
        <th><b><img src=" <?= base_url('assets/imagenes/likert/') ?>2.png" style="width: 50px"></b></th>
        <th><b><img src=" <?= base_url('assets/imagenes/likert/') ?>3.png" style="width: 50px"></b></th>
        <th><b><img src=" <?= base_url('assets/imagenes/likert/') ?>4.png" style="width: 50px"></b></th>
        <th><b><img src=" <?= base_url('assets/imagenes/likert/') ?>5.png" style="width: 50px"></b></th>
     
       </tr>

  </thead>
 

  
  <tr>
    <td>Atencion<br></td>
    <td><input type="radio" name="atencion" value="1"><br></td>
    <td><input type="radio" name="atencion" value="2"><br></td>
    <td><input type="radio" name="atencion" value="3"><br></td>
    <td><input type="radio" name="atencion" value="4"><br></td>
    <td><input type="radio" name="atencion" value="5"><br></td>

  </tr>
  <tr>
    <td>Servicio<br></td>
    <td><input type="radio" name="servicio" value="1"><br></td>
    <td><input type="radio" name="servicio" value="2"><br></td>
    <td><input type="radio" name="servicio" value="3"><br></td>
    <td><input type="radio" name="servicio" value="4"><br></td>
    <td><input type="radio" name="servicio" value="5"><br></td>
  </tr>
  <tr>
    <td>Rapidez<br></td>
    <td><input type="radio" name="rapidez" value="1"><br></td>
    <td><input type="radio" name="rapidez" value="2"><br></td>
    <td><input type="radio" name="rapidez" value="3"><br></td>
    <td><input type="radio" name="rapidez" value="4"><br></td>
    <td><input type="radio" name="rapidez" value="5"><br></td>
  </tr>
    <tr>
    <td>Temperatura<br></td>
    <td><input type="radio" name="temperatura" value="1"><br></td>
    <td><input type="radio" name="temperatura" value="2"><br></td>
    <td><input type="radio" name="temperatura" value="3"><br></td>
    <td><input type="radio" name="temperatura" value="4"><br></td>
    <td><input type="radio" name="temperatura" value="5"><br></td>
  </tr>
    <tr>
    <td>Sabor<br></td>
    <td><input type="radio" name="sabor" value="1"><br></td>
    <td><input type="radio" name="sabor" value="2"><br></td>
    <td><input type="radio" name="sabor" value="3"><br></td>
    <td><input type="radio" name="sabor" value="4"><br></td>
    <td><input type="radio" name="sabor" value="5"><br></td>
  </tr>
    <tr>
    <td>Porcion<br></td>
    <td><input type="radio" name="porcion" value="1"><br></td>
    <td><input type="radio" name="porcion" value="2"><br></td>
    <td><input type="radio" name="porcion" value="3"><br></td>
    <td><input type="radio" name="porcion" value="4"><br></td>
    <td><input type="radio" name="porcion" value="5"><br></td>
  </tr>

  <tr>
    <td colspan="6" style="width: 100%;"><b>Comentarios:</b><textarea style="width: 100%; resize: none" name="comentarios"></textarea></td>
   
  </tr>
  <tr>
    <td colspan="6" style="width: 100%;"><b>Datos:</b>
    <br>
    <br>

   

    <div class="row">
    <div class="col-sm-8"><input type="text" class="form-control" placeholder="Nombre" name="nombre"></div>
    <div class="col-sm-4"><input type="number" class="form-control" placeholder="Edad" name="edad"></div>
    </div>
    <div class="row mt-3">
    <div class="col-sm-12"><input type="email" class="form-control" placeholder="Correo electronico" name="email"></div>
    </div>

    

   <div class="row mt-3">
    <div class="col-sm-12 " style="text-align: center; width: 100%"><button class="btn btn-dark mt-3 pull-rigth" ><h4>Enviar</h4> </button></div>
    </div>
  
    </td>

 
  </tr>
</table>

  </form>


</div>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".encuesta tr td").click(function(){
        $(this).find('input').prop("checked", true);
        $("input[type='radio']").each(function(){
          if($(this).is(":checked")){ $(this).parent("td").attr("style","background-color:green");}
          else{$(this).parent("td").removeAttr('style');}
        })
      })
    });
  </script>