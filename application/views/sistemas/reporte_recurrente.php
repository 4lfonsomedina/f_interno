<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://ferbis.com/PWA/actividades/assets/css/bootstrap.css?v6">
<link rel="stylesheet" href="https://ferbis.com/PWA/actividades/assets/css/font-awesome.min.css">


<style type="text/css">
    .label_limite{
      position: absolute;
      right: 5px;
      top: -14px;
    }
    .progress{
      margin-bottom: 0px !important;
    }
    .recuadro_insidencia{
      border: 1px solid #CFCFCF;
      border-radius: 5px;
      padding: 5px;
    }
    .boton_recurrente {
      padding: 2px 7px 2px 7px;
      border-radius: 5px;
      right: -5px;
      top: 15px;
      position: relative;
    }
    .padding_top_20{
      width: 100%;
      padding-top: 20px;
     }
     .close{
      font-size: 50px;
      text-align: right;
     }
     button{
      width: 100%;
     }
	@media print { 
    /* All your print styles go here */
   .progress{
     background-color: #f5f5f5 !important;
     border-radius: 4px !important;
     border: solid 1px black !important;
     margin-bottom: 0px !important;
   }
   .progress-bar{
      background-color: #428bca !important;
      border: solid 1px black !important;
   }
   .filtrar{
    display: none;
   }

		td{ padding-top: 0px; padding-bottom: 0px; font-size: 10px; }
	}
</style>



<div class="col-sm-12" style="padding-top:20px; padding-bottom: 20px; position:fixed; background-color: #FFC860;padding-right: 5px; padding-left: 5px; z-index: 2; width: 100%; font-weight:bold; text-align:center;" id="banner_filtro"> FILTRO ︾</div>
<div class="col-sm-12" style="padding-top:20px; padding-bottom: 20px; position:fixed; background-color: #FFC860;padding-right: 5px; padding-left: 5px; z-index: 1;" id="banner_filtro2" hidden>
	<form action="<?= site_url('sistemas/sistemas/reporte_recurrente') ?>" method="POST" id="form_recurrentes">
		<input type="hidden" value="<?= $departamento ?>" name="departamento">
		<div class="col-xs-6 col-md-3">
			<input type="date" value="<?= $fecha1 ?>" name="fecha1" class="form-control input-sm" id="fecha1_recurrente"><br>
		</div>
		<div class="col-xs-6 col-md-3">
			<input type="date" value="<?= $fecha2 ?>" name="fecha2" class="form-control input-sm" id="fecha2_recurrente"><br>
		</div>
		<div class="col-xs-12 col-md-3">
			<select class="form-control input-sm" name="recurrente" id="id_recurrente">
				<option value="0">Todos</option>
				<?php foreach($recurrentes_todos as $rec2){?>
					<option value="<?= $rec2->id_recurrente ?>" <?php if($recurrente == $rec2->id_recurrente){ echo "selected"; }?>>
						<?= formato_hora($rec2->limite) ?> <?= $rec2->titulo ?></option>
				<?php } ?>
			</select><br>
		</div>
		<div class="col-xs-9  col-md-2">
			<button class="btn btn-success btn-sm filtrar" style="width: 100%">Filtrar</button>
      
		</div>
    <div class="col-xs-3  col-md-1">
      <a class="btn btn-info btn-sm" id="ocultar_banner_filtro" style="width: 100%">︽</a>
    </div>
	</form>
</div>
<div class="col-xs-12" style="height: 80px;"></div>
<div style="width: 100%; overflow-x: auto;">
    
    <div class='col-md-12' style="margin-bottom: 20px;">
      <select class="form-control" id="filter_input">
        <option value="">TODO</option>
        <option value="BRASIL">BRASIL</option>
        <option value="SAN MARCOS">SAN MARCOS</option>
        <option value="GASTRO">GASTRO</option>
      </select>
    </div>

<?php foreach($recurrentes as $rec){ 
  $terminada = "default"; 
  if($rec->campos[0]->lectura!=""){ $terminada="success";}elseif(strtotime($rec->limite)<strtotime(date('H:m:s'))){ $terminada="danger"; }
  $total_campos=count($rec->campos);
  $aprobacion=0;
  $num_campos=0;
  $mensaje="";
  $usuario = str_replace(" ","",explode("-",$rec->campos[0]->responsable)[0]);
  $id_personal = $this->db->select("id_personal")->where("usuario",$usuario)->get('personal');
  if($id_personal->num_rows()>0){
    $id_personal=$id_personal->row()->id_personal;
  }else{
    $id_personal=0;
  }
  foreach($rec->campos as $campo){
    $boton_actividad = "<div style='text-align:right'><a class='btn btn-primary boton_recurrente'  departamento='".$departamento."' id_personal='".$id_personal." ' titulo='".$campo->titulo."' descripcion='".$campo->subtitulo."'><i class='fa fa-tag' aria-hidden='true'></i></a></div>";

    if($campo->subtitulo!=""){ $campo->subtitulo = "<br>".$campo->subtitulo."<br>"; }
    if($campo->tipo=="0"&&$campo->lectura=="1"){$aprobacion++;}
    if($campo->tipo=="1"&&($campo->lectura>=$campo->min&&$campo->lectura<=$campo->max)){$aprobacion++;}
    if($campo->tipo=="0"&&$campo->lectura=="0"){

       $mensaje.="<br>".$boton_actividad.
      " <div class='recuadro_insidencia'><span class='label label-default'>".$campo->fecha2."</span>".
      " <span class='label label-danger'> X </span> ".
      " &nbsp<b> ".$campo->titulo."</b>".$campo->subtitulo.
      " <span class='label label-success'>".$campo->responsable."</span>".
      $campo->observacion."</div>";
      
    }
    if($campo->tipo=="1"&&$campo->lectura!=""&&($campo->lectura<$campo->min||$campo->lectura>$campo->max)){
      $mensaje.="<br>".$boton_actividad.
      " <div class='recuadro_insidencia'><span class='label label-default'>".$campo->fecha2."</span>".
      " <span class='label label-primary'>".$campo->lectura."</span>".
      " <b> ".$campo->titulo."</b>".$campo->subtitulo.
      " <span class='label label-success'>".$campo->responsable."</span>".
      " <span class='label label-danger'> Fuera de rango (".$campo->min."-".$campo->max.")</span>".
      $campo->observacion."</div>";
    }
    
  }
  if($mensaje==""){
    $mensaje="Actividad sin incidencias <i class='fa fa-thumbs-o-up' aria-hidden='true'></i>";
  }
  $num_campos = $total_campos-$aprobacion;
  $aprobacion = round(($aprobacion/$total_campos)*100,1);
  ?>



   <div class="col-md-4 col-sm-2 col_recurrente">
    <div class="panel panel-default panel_recurrente" 
    departamento="<?= $departamento ?>"
    fecha1="<?= $fecha1 ?>"
    fecha2="<?= $fecha2 ?>"
    recurrente="<?= $rec->id_recurrente ?>"
    >
      <div class="panel-heading hidden_pannel heading_recurrente" data-toggle="collapse" data-target=".div_recurrente_<?= $rec->id_recurrente ?>">
          <b><?= $rec->titulo ?></b><span class="pull-right"></span>
          <span class="label label-<?= $terminada ?> label_limite " style="font-size: 16px;">
            <i class="fa fa-clock-o" aria-hidden="true"></i> <?= formato_hora($rec->limite) ?>
          </span>
      </div>
      <?php if($num_campos!=$total_campos){?>
      <div class="panel-footer">
        <center><b>Aprobación</b></center>
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $aprobacion ?>%;">
            <?= $aprobacion ?>%
          </div>
        </div>
      </div>
      <?php } ?>
      
    </div>
</div>
  <?php } ?>
</div>














<!--  MODAL CREAR ACTIVIDAD  -->
<div class="modal fade" id="modal_actividades" role="dialog">
    <div class="modal-dialog">
    
      <!-- CONTENIDO DE MODAL-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ACTIVIDAD</h4>
        </div>
        <div class="modal-body" id="modal_actividades_body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="modal_show_recurrente" role="dialog">
    <div class="modal-dialog">
    
      <!-- CONTENIDO DE MODAL-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TAREA RECURRENTE</h4>
        </div>
        <div class="modal-body" id="modal_show_recurrente_body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
        </div>
      </div>
      
    </div>
  </div>




<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function() {



    console.log(location.hostname);
    var base_url = location.hostname;
    if(base_url=='192.168.1.10')
      base_url="http://192.168.1.10/ferbis-interno/index.php/sistemas/sistemas/";
    if(base_url=="ferbis.com"){
      base_url="https://ferbis.com/PWA/actividades/index.php/sistemas/sistemas/alta_actividad_view/";
    }



    $(".panel_recurrente").click(function(){
      $.post(base_url+"/show_recurrente",{
        departamento:$(this).attr('departamento'),
        fecha1:$(this).attr('fecha1'),
        fecha2:$(this).attr('fecha2'),
        recurrente:$(this).attr('recurrente')
      },function(r){
        $('#modal_show_recurrente_body').html(r);
        $("#modal_show_recurrente").modal("show");
      })
    })

    $(document).on("click",".imp_rec_btn",function(){
      $("."+$(this).attr("mostrar")).slideToggle();
    })
    $(document).on("click",".hidden_pannel",function(){
      $(this).parent('div').find('.panel-body').slideToggle();
    });
    $(document).on("click","#banner_filtro",function(){
      $("#banner_filtro").slideUp();
      $("#banner_filtro2").slideDown();
    })
    $(document).on("click","#ocultar_banner_filtro",function(){
      $("#banner_filtro2").slideUp();
      $("#banner_filtro").slideDown();
    })
    $(document).on("click","#filter_input",function(){
      var val = this.value.toLowerCase();
      console.log(val);
      $('.col_recurrente').slideDown().filter(function() {
          var panelTitleText = $(this).find('.heading_recurrente').text().toLowerCase();
          return panelTitleText.indexOf(val) < 0;
      }).slideUp(800);
    });
    
    console.log(base_url);
    $(document).on("click",".boton_recurrente",function(){
      $('#modal_actividades').modal("show");
      $('#modal_actividades_body').html(loader());
      $.post(base_url+"/alta_actividad_view"+$(this).attr('departamento'),{
        id_personal:$(this).attr('id_personal'),
        titulo:$(this).attr('titulo'),
        descripcion:$(this).attr('descripcion'),
      },function(r){
        $('#modal_actividades_body').html(r);
      })
    })

    function loader(){
      var loader="<div class='col col-lg-12 loader_ocu'><div class='spinner'>"+
      "<div class='rect1'>"+
      "</div><div class='rect2'>"+
      "</div><div class='rect3'>"+
      "</div><div class='rect4'>"+
      "</div><div class='rect5'>"+
      "</div></div></div>";
      return loader;
    }

  });
</script>