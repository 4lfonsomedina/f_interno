<style type="text/css">
  .panel-primary{
    z-index: 0px;
  }
</style>
<!-- LIBRERIAS DE CALENDARIO-->
<div class="col col-md-1"></div>

<!--CONTENEDOR Y PANEL PRINCIPALES-->
<div class="col col-md-10">
  <div class="panel panel-default">
    <div class="panel-heading titulo_panel"><div class='row'>
      <div class="col col-md-6">Actividades Area de <?php foreach($departamentos as $dep){if($dep->id_departamento==$departamento){echo $dep->nombre;}}?> </div>
    <div class="col col-md-2">
      <a target="_blank" class="btn btn-primary" href="<?= site_url('sistemas/sistemas/imprimir_actividades?d=').$departamento.'&p='.$responsable.'&s='.$solicitante ?>" style="width: 50px "><i class="fa fa-print" aria-hidden="true"></i></a>
      <a class="btn btn-default fixed_check" style="width: 50px "><i class="fa fa-calendar-check-o" aria-hidden="true"></i></a>
      <a class="btn btn-success" id="alta_actividad_btn" departamento='<?= $departamento?>' style="width: 50px ">
        <i class="fa fa-calendar-plus-o" aria-hidden="true" ></i>
      </a>
      <a class="btn btn-warning" id="reporte_recurrente" departamento='<?= $departamento?>' style="width: 50px ">
        <i class="fa fa-refresh" aria-hidden="true"></i> <i class="fa fa-file-text-o" aria-hidden="true"></i>
      </a>
    </div>

    <div class="col col-md-2">
       <select class="form-control" id="filtro_solicitante" departamento='<?= $departamento?>'>
    <option value="0">DEPARTAMENTOS</option>
          <?php foreach($departamentos as $d){?>
          <option value="<?= $d->id_departamento ?>" 
            <?php if($d->id_departamento==$solicitante){echo "selected";} ?>
            ><?= $d->nombre ?></option>
        <?php } ?>
      </select>

     </div>


     <div class="col col-md-2">
      <select class="form-control" id="filtro_responsable" departamento='<?= $departamento?>'>
    <option value="0">PERSONAL</option>
        <?php foreach($personal as $p){?>
          <option value="<?= $p->id_personal ?>" 
            <?php if($p->id_personal==$responsable){echo "selected";} ?>
            ><?= $p->nombre ?></option>
        <?php } ?>
      </select>
      </div>
  </div>
  </div>
    <div class="panel-body">


<!-- TABS -->
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#actividades_dash">
      <i class="fa fa-tachometer" aria-hidden="true"></i></a>
    </li>
    <li ><a data-toggle="tab" href="#actividades_activas">
      <i class="fa fa-tasks" aria-hidden="true"></i></a>
    </li>
    <li><a data-toggle="tab" href="#actividades_calendario">
      <i class="fa fa-calendar" aria-hidden="true"></i></a>
    </li>
    <li><a data-toggle="tab" href="#recurrentes">
      <i class="fa fa-refresh" aria-hidden="true"></i></a>
    </li>
    <li id="tab_historico_actividades"><a data-toggle="tab" href="#historico_actividades">
      <i class="fa fa-check-square-o" aria-hidden="true"></i></a>
    </li>
  </ul>



<!-- CONTENEDORES DE TABS-->
  <div class="tab-content">
    <!-- DASHBOARD ACTIVIDADES -->
    <div id="actividades_dash" class="tab-pane fade in active">
      <!-- CICLO PARA LOS 3 DIAS -->
      <div class="row"><br>
        
<?php 
//Ayer
$cual='Ayer';$dia = resta_dias(date('d/m/Y'),1);
for($i=0;$i<3;$i++){
//Hoy
if($i==1){$cual='Hoy';$dia = date('d/m/Y');}
//Mañana
if($i==2){$cual='Mañana';$dia = suma_dias(date('d/m/Y'),1);}
?>

        <!-- panel contenedor -->
<div class="col col-sm-4">

<div class="panel panel-primary">
<div class="panel-heading titulo_panel" style="font-size: 16px;"><b>Actividades de <?= $cual ?></b> <?= $dia ?> <i class="fa fa-calendar" aria-hidden="true"></i> </div>
<div class="panel-body drag_test" fecha_dia="<?= $dia ?>">
<div class="limite_x_700 contenedor_dia" dia="<?= $dia ?>" >
<?php $cont_atc=1;foreach($actividades1 as $act)if(formato_fecha($act->fecha_ini)==$dia){?>
<div class="row">
<div class='col col-xs-12 contenedor_actividades_act' orden=''>
<div class="widgets2" fecha_act="<?= $dia ?>" actividad='<?= $act->id_actividad ?>'>
<div class="panel panel-default">
<input type='hidden' name='act[]' value='<?= $act->id_actividad ?>'>
<input type='hidden' class="input_orden" name='orden[<?= $act->id_actividad ?>]' value='<?= $cont_atc++; ?>'>

<div class="panel-heading heading_actividades" data-toggle="collapse" data-target=".div_act_<?= $act->id_actividad ?>">
<h4><b><?= $act->actividad ?></b>
<?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
<span class="label label-<?= $e->color ?> pull-right"><?= $e->estatus ?></span> </h4>
<?php }?></h4>
</div>
<div class="panel-body collapse div_act_<?= $act->id_actividad ?>">
<div class="col col-xs-10">
<p><b>DESCRIPCION: </b> <?= nl2br($act->descripcion) ?></p>
<?php if($act->observaciones!=''){?><br><p><b>OBSERVACIONES: </b> <?= nl2br($act->observaciones) ?></p><?php } ?>
<?php if(file_exists(path_adjunto($act->id_actividad))){?>
  <a href='#' id="img_adjunto" img="<?= base_url().'/assets/archivos/act_adjunto_'.$act->id_actividad.'.png?'.rand(0, 1000);?>" class="link_adjunto">1 archivo adjunto</a>
<?php } ?>
</div>
<div class="col col-xs-2 no_padding" align="right">
<a class="btn btn-warning editar_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='EDITAR'>
<i class="fa fa-pencil" aria-hidden="true"></i>
</a>
<a class="btn btn-danger baja_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='BORRAR'>
<i class="fa fa-trash" aria-hidden="true"></i>
</a><br>
<a class="btn btn-default edicion_act" title='IMPRIMIR' target="_blank" href="<?= site_url('sistemas/sistemas/imprimir_actividad?a=').$act->id_actividad?>" >
<i class="fa fa-print" aria-hidden="true"></i>
</a>
<a class="btn btn-success concluir_act edicion_act" id_actividad="<?= $act->id_actividad ?>" title='CONCLUIR'>
<i class="fa fa-check" aria-hidden="true"></i>
</a>
</div>
</div>

<div class="panel-footer footer_actividades"><div class="row">
<div class="col col-xs-6">
  <?php foreach($personal as $p){?>
    <?php if($act->id_responsable==$p->id_personal){echo $p->nombre;} ?>
  <?php } ?>
</div>
<div class="col col-xs-6" style="text-align: right; font-weight: bold">
  <?php foreach($departamentos as $d)if($act->id_solicitante==$d->id_departamento) echo $d->nombre; ?>
</div>
<!--<div class="col col-xs-4 importe"><b>Fecha FIN:</b> <?= formato_fecha($act->fecha_fin) ?></div>-->
</div></div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>

<?php } ?>
</div>

      
      
        

    </div>
      <!-- TODAS LAS ACTIVIDADES QUE TIENEN ESTATUS DIFERENTE DE CONCLUIDO -->
    <div id="actividades_activas" class="tab-pane fade">
      <br>
      <div class="limite_x_700" >
        <form id="orden_act_form">
        <input type="hidden" value="<?= $departamento ?>" id="act_depto" name="dep_act">

          <div class='col col-lg-12' style="margin-bottom: 20px;">
            <input type="text" class="form-control" id="filter_input2" placeholder="Buscar">
          </div>
          
      <?php $cont_atc=1;foreach($actividades1 as $act)if($act->estatus!='0'){?>
        
        <div class='col col-lg-6 contenedor_actividades_act' orden=''>
      <div class="panel panel-default">
        <input type='hidden' name='act[]' value='<?= $act->id_actividad ?>'>
        <input type='hidden' class="input_orden" name='orden[<?= $act->id_actividad ?>]' value='<?= $cont_atc++; ?>'>
        
        <div class="panel-heading heading_actividades" data-toggle="collapse" data-target=".div_act_<?= $act->id_actividad ?>">
        <h4><b><?= $act->actividad ?></b>
        <?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
        <span class="label label-<?= $e->color ?> pull-right"><?= $e->estatus ?></span> </h4>
        <?php }?></h4>
        </div>
        <div class="panel-body collapse div_act_<?= $act->id_actividad ?>">
          <div class="col col-xs-10">
            <p><b>DESCRIPCION: </b> <?= nl2br($act->descripcion) ?></p>
            <?php if($act->observaciones!=''){?><br><p><b>OBSERVACIONES: </b> <?= nl2br($act->observaciones) ?></p><?php } ?>
            <?php if(file_exists(path_adjunto($act->id_actividad))){?>
  <a href='#' id="img_adjunto" img="<?= base_url().'/assets/archivos/act_adjunto_'.$act->id_actividad.'.png?'.rand(0, 1000);?>" class="link_adjunto">1 archivo adjunto</a>
<?php } ?>
          </div>
          <div class="col col-xs-2 no_padding" align="right">
            <a class="btn btn-warning editar_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='EDITAR'>
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <a class="btn btn-danger baja_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='BORRAR'>
              <i class="fa fa-trash" aria-hidden="true"></i>
            </a><br>
            <a class="btn btn-default edicion_act" title='IMPRIMIR' target="_blank" href="<?= site_url('sistemas/sistemas/imprimir_actividad?a=').$act->id_actividad?>" >
              <i class="fa fa-print" aria-hidden="true"></i>
            </a>
            <a class="btn btn-success concluir_act edicion_act" id_actividad="<?= $act->id_actividad ?>" title='CONCLUIR'>
              <i class="fa fa-check" aria-hidden="true"></i>
            </a>
          </div>
          </div>

          <div class="panel-footer footer_actividades"><div class="row">
            <div class="col col-xs-4"><b>Fecha inicio:</b> <span id='fecha_ini_act_<?= $act->id_actividad ?>'><?= formato_fecha($act->fecha_ini) ?></span></div>
            <div class="col col-xs-4"><center>
              <?php foreach($personal as $p){?>
                <?php if($act->id_responsable==$p->id_personal){echo $p->nombre;} ?>
              <?php } ?>
              
              </center></div>
              <div class="col col-xs-4" style="text-align: right; font-weight: bold">
                <?php foreach($departamentos as $d)if($act->id_solicitante==$d->id_departamento) echo $d->nombre; ?>
              </div>
            <!--<div class="col col-xs-4 importe"><b>Fecha FIN:</b> <?= formato_fecha($act->fecha_fin) ?></div>-->
          </div></div>
      </div>
    </div>
  <?php } ?>
  </form>
  </div>
  </div>


  <!-- CALENDARIO DE ACTIVIDADES -->
  <div id="actividades_calendario" class="tab-pane fade in active">
    <br><div id='calendar' style="width: 100%; max-width: 100% !important"></div>
  </div>




<!-- ACTIVIDADES RECURRENTES -->
<div id="recurrentes" class="tab-pane fade in" style="padding-top: 20px">
  <div class="row">
      <div class="col-xs-12" style="text-align: right;"><a href="#" id="btn_alta_recurrentes" class="btn btn-success" style="max-width: 250px;"><i class="fa fa-plus" aria-hidden="true"></i> Recurrente</a><br><br></div>
  </div>
  <?php foreach($recurrentes as $rec){?>
    <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading" data-toggle="collapse" data-target=".div_recurrente_<?= $rec->id_recurrente ?>">
          <?php 
          $palomita="<span class='label label-success label_limite'> <i class='fa fa-check' aria-hidden='true'></i> ";
          if($rec->valor==''){ $estatus_R="warning"; if(strtotime($rec->limite)<strtotime(date('H:m:s')) ){ $estatus_R="danger"; }
            $palomita="<span class='label label-".$estatus_R." label_limite'> <i class='fa fa-clock-o' aria-hidden='true'></i> "; 
          } ?>
          <?= $palomita.formato_hora($rec->limite) ?></span>

          <b><?= $rec->titulo ?></b>
          <span class="pull-right">
            <a class="btn btn-info btn-xs editar_recurrente" id_recurrente='<?= $rec->id_recurrente ?>'><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </span>
          <span class="pull-right" style="margin-right: 10px;">
            <a class="btn btn-warning btn-xs duplicar_recurrente" id_recurrente='<?= $rec->id_recurrente ?>'><i class="fa fa-files-o" aria-hidden="true"></i></a>
          </span>
          
      </div>
      <div class="panel-body collapse div_recurrente_<?= $rec->id_recurrente ?>">
        <?= $rec->descripcion ?>
      </div>
      <div class="panel-footer">
        <?php if($rec->valor==''){ ?>
        <a class="btn btn-primary realizar_t" id_recurrente='<?= $rec->id_recurrente ?>'><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Realizar Tarea</a>
        <?php }else{ ?>
          <a class="btn btn-success realizar_t" id_recurrente='<?= $rec->id_recurrente ?>'><i class="fa fa-check" aria-hidden="true"></i> Revision de captura</a>
        <?php } ?>
      </div>
    </div>
    </div>
  <?php } ?>
</div><!-- ACTIVIDADES RECURRENTES -->

  <!-- TODAS LAS ACTIVIDADES QUE TIENEN ESTATUS CONCLUIDO -->
    <div id="historico_actividades" class="tab-pane fade">
      <br>
     <div class="limite_x_700">
      <div class='col col-lg-12' style="margin-bottom: 20px;">
        <input type="text" class="form-control" id="filter_input" placeholder="Buscar">
      </div>
      <?php foreach($actividades2 as $act){?>
        <div class='col col-lg-6 panel_conluidos'>
      <div class="panel panel-success">
        <div class="panel-heading heading_actividades" data-toggle="collapse" data-target=".div_act_<?= $act->id_actividad ?>"><h4><b><?= $act->actividad ?></b>
        <?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
        <span class="label label-<?= $e->color ?> pull-right"><?= $e->estatus ?></span> </h4>
        <?php }?></h4>
      </div>
        <div class="panel-body collapse div_act_<?= $act->id_actividad ?>">
          <div class="col col-xs-10">
            <p><b>DESCRIPCION: </b> <?= nl2br($act->descripcion) ?></p>
            <?php if($act->observaciones!=''){?><br><p><b>OBSERVACIONES: </b> <?= nl2br($act->observaciones) ?></p><?php } ?>
            <?php if(file_exists(path_adjunto($act->id_actividad))){?>
  <a href='#' id="img_adjunto" img="<?= base_url().'/assets/archivos/act_adjunto_'.$act->id_actividad.'.png?'.rand(0, 1000);?>" class="link_adjunto">1 archivo adjunto</a>
<?php } ?>
          </div>
          <div class="col col-xs-2 no_padding">
            <a class="btn btn-warning editar_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='EDITAR'>
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <a class="btn btn-danger baja_actividad edicion_act" id_actividad="<?= $act->id_actividad ?>" title='BORRAR'>
              <i class="fa fa-trash" aria-hidden="true"></i>
            </a><br>
            <a class="btn btn-default edicion_act" title='IMPRIMIR' target="_blank" href="<?= site_url('sistemas/sistemas/imprimir_actividad?a=').$act->id_actividad?>" >
              <i class="fa fa-print" aria-hidden="true"></i>
            </a>
            <a class="btn btn-info calificar_link edicion_act" title='CALIFICAR' enlace="Me ayudas calificando mi servicio: https://ferbis.com/encuesta/index.php/Actividades_Controller/encuesta?id=<?= $act->id_actividad ?>" >
              <i class="fa fa-star" aria-hidden="true"></i>
            </a>
          </div>
          <div class="col col-xs-12" style="font-weight: bold">
                <?php foreach($departamentos as $d)if($act->id_solicitante==$d->id_departamento) echo $d->nombre; ?>
              </div>
          </div>

          <div class="panel-footer footer_actividades"><div class="row">
            <div class="col col-xs-4"><b>Fecha inicio:</b> <?= formato_fecha($act->fecha_ini) ?></div>
            <div class="col col-xs-4"><center><?php foreach($personal as $p){?>
                <?php if($act->id_responsable==$p->id_personal){echo $p->nombre;} ?>
              <?php } ?></center></div>
            <div class="col col-xs-4
             importe"><b>Finalizada:</b> <span id='fecha_ini_act_<?= $act->id_actividad ?>'><?= formato_fecha($act->fecha_fin) ?></span></div>
          </div></div>
      </div>
    </div>

  <?php } ?>
</div>
    </div>
  </div>


</div>

</div></div>


<div class="contenedor_check" hidden>
  <a href="#" id="aconfig_check"><i class="fa fa-cog" aria-hidden="true"></i></a>
  <button type="button" class="close ocultar_check"><i class="fa fa-times" aria-hidden="true"></i></button>
  <br>
  <div class="separar_1"></div>
  <input type="hidden" id="acts_departamento" value="<?= $departamento?>">
  <input type="text" class="form-control datepicker" id="fecha_check" value="<?= date('d/m/Y') ?>" style="width: 50%">
  <div class="separar_1 cargar_check">
  </div>

</div>

<!--  MODAL REPORTE RECURRENTES -->
  <div class="modal fade" id="modal_reporte_recurrentes" role="dialog">
    <div class="modal-dialog">
    
      <!-- CONTENIDO DE MODAL-->
      <div class="modal-content">
        <form method="POST" action="<?= site_url('sistemas/sistemas/reporte_recurrente') ?>">
          <input type="hidden" name="recurrente" value='0'>
          <input type="hidden" name="departamento" value='<?= $departamento ?>'>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">REPORTE DE RECURRENTE POR PERIODO</h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-xs-6">
              FECHA INICIAL<input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="fecha1">
            </div>
            <div class="col-xs-6">
              FECHA FINAL<input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="fecha2">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-success">Generar Reporte</button>
        </div>
      </form>
      </div>
    </div>
  </div>
<!-- MODAL RECURRENTES -->
<div class="modal fade" id="modal_recurrentes" role="dialog">
    <div class="modal-dialog">
    
      <!-- CONTENIDO DE MODAL-->
      <div class="modal-content">
        <input type="hidden" id="url_alta_recurrente" value="<?= site_url('sistemas/sistemas/alta_recurrente') ?>">
        <input type="hidden" id="url_editar_recurrente" value="<?= site_url('sistemas/sistemas/editar_recurrente') ?>">
        <!-- form -->
        <form action="<?= site_url('sistemas/sistemas/alta_recurrente') ?>" method="post" id="form_recurrente">
          <input type="hidden" name="id_departamento" value="<?= $departamento?>">
          <input type="hidden" name="id_recurrente" id="form_id_recurrente" value="">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">RECURRENTE</h4>
        </div>
        <div class="modal-body" id="modal_recurrentes_body">
          
          <div class="row">
            <div class="col-md-8">
              <b>Titulo:</b>
              <input type="text" class="form-control" name="titulo" id="rec_titulo">
            </div>
            <div class="col-md-4">
              <b>Hora limite:</b>
              <select class="form-control" name="limite" id="rec_limite">
                <option value="07:30:00"> 07:30 </option>
                <option value="08:00:00"> 08:00 </option>
                <option value="08:30:00"> 08:30 </option>
                <option value="09:00:00"> 09:00 </option>
                <option value="09:30:00"> 09:30 </option>
                <option value="10:00:00"> 10:00 </option>
                <option value="10:30:00"> 10:30 </option>
                <option value="11:00:00"> 11:00 </option>
                <option value="11:30:00"> 11:30 </option>
                <option value="12:00:00"> 12:00 </option>
                <option value="12:30:00"> 12:30 </option>
                <option value="13:00:00"> 13:00 </option>
                <option value="13:30:00"> 13:30 </option>
                <option value="14:00:00"> 14:00 </option>
                <option value="14:30:00"> 14:30 </option>
                <option value="15:00:00"> 15:00 </option>
                <option value="15:30:00"> 15:30 </option>
                <option value="16:00:00"> 16:00 </option>
                <option value="16:30:00"> 16:30 </option>
                <option value="17:00:00"> 17:00 </option>
                <option value="17:30:00"> 17:30 </option>
                <option value="18:00:00"> 18:00 </option>
                <option value="18:30:00"> 18:30 </option>
                <option value="19:00:00"> 19:00 </option>
                <option value="19:30:00"> 19:30 </option>
                <option value="20:00:00"> 20:00 </option>
                <option value="20:30:00"> 20:30 </option>
                <option value="21:00:00"> 21:00 </option>
                <option value="21:30:00"> 21:30 </option>
              </select>
            </div>
            <div class="col-md-12">
              <br><b>Descripcion:</b>
              <textarea rows="3" class="form-control" id="rec_desc" name="descripcion"></textarea>
            </div>
            <div class="col-md-12">
              <br>
              <a class="btn btn-primary" id="btn_alta_campo"> Agregar campo <i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
            </div>
            <div class="col-md-12" style="height: 400px; overflow-y: auto;">
              <table class="table">
                <thead>
                <tr>
                  <th>Nomble</th>
                  <th>Descripcion</th>
                  <th>tipo</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="contenedor_campos">
              </tbody>
              </table>
            </div>
            </div>
          </div>
        <div class="modal-footer">
          <div class="row">
          <div class="col-xs-4">
            <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-reply" aria-hidden="true"></i></button>
          </div>
          <div class="col-xs-4">
              <button type="button" class="btn btn-danger" id="eliminar_recurrente" id_recurrente=""><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-success"> <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
          </div>
          </div>
        </div>
        </form>
      </div>
      
    </div>
  </div>
  <!-- MODAL CHECK RECURRENTE -->
  <div class="modal fade" id="modal_check_recurrente" role="dialog">
    <div class="modal-dialog">
    
      <!-- CONTENIDO DE MODAL-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TAREA RECURRENTE</h4>
        </div>
        <div class="modal-body" >
          <form action="<?= site_url('sistemas/sistemas/registrar_recurrente') ?>" method="POST" id="form_registro_recurrente">
            <textarea hidden class="text_rec_titulo" name="titulo"></textarea>
             <textarea hidden class="text_rec_limite" name="limite"></textarea>
              <textarea hidden class="text_rec_desc" name="descripcion_tarea"></textarea>
            <input type="hidden" name="id_departamento" value="<?= $departamento ?>">
            <input type="hidden" name="responsable" value="WEB">
          <div class="row">
            <div class="col-md-8"><b>Titulo:</b><br><span class="text_rec_titulo"></span></div>
            <div class="col-md-4"><b>Limite:</b><br><span class="text_rec_limite"></span></div>
            <div class="col-md-12"><b>Descripcion:</b><br><span class="text_rec_desc"></span></div>
          </div>
          <div class="modal_check_recurrente_body"></div>
          <div class="contenedor_campos_2" style="height: 40vh;overflow-y: auto;">
            <table class="table">
              <tbody id="contenedor_campos_2">
              </tbody>
              </table>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-xs-6">
              <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
            </div>
            <div class="col-xs-6">
              <button type="button" class="btn btn-success" id="btn_guardar_check_recurrente"> <i class="fa fa-floppy" aria-hidden="true"></i> Guardar</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL MULTIUSOS -->
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


  <!-- MODAL IMAGENES -->
<div id="myModalimg" class="modal_img">
  <span class="close_img">&times;</span>
  <img class="modal_img-content" id="img01">
  <div id="caption">Adjunto</div>
</div>