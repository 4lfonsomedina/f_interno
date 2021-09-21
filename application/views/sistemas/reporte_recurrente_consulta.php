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
    $boton_actividad = "<div style='text-align:right'><a class='btn btn-primary boton_recurrente'  departamento='".$departamento."' id_personal='".$id_personal." ' titulo='".$campo->titulo."' observacion='".$campo->subtitulo."\n".$campo->observacion."'><i class='fa fa-tag' aria-hidden='true'></i></a></div>";

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



   
          <h3><?= $rec->titulo ?></h3><span class="pull-right"></span>
          <span class="label label-<?= $terminada ?> label_limite " style="font-size: 16px;">
            <i class="fa fa-clock-o" aria-hidden="true"></i> <?= formato_hora($rec->limite) ?>
          </span>

        <!--<?= $rec->descripcion ?>-->
        <!-- ciclo entre fechas para mostrar imagenes -->
        <?php 
        $path = getcwd()."\\assets\\archivos\\recurrentes\\rec_adjunto_".$rec->id_recurrente.'_'.$fecha1.'.png';
        //$path = 'http://192.168.1.10/ferbis-interno/assets/archivos/recurrentes/rec_adjunto_'.$rec->id_recurrente.'_'.$fecha1.'.png';
        if($fecha1==$fecha2&&file_exists($path)){ 
          $type = pathinfo($path, PATHINFO_EXTENSION);
          $data = file_get_contents($path);
          $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
          ?>
          <img src="<?= $base64 ?>" style="width:100%"><br><br>
        <?php } ?>

        <?php if($num_campos!=$total_campos){?>
        <div class="btn btn-warning imp_rec_btn" style="width: 100%" 
        mostrar="incidencia_recurrente_<?=$rec->id_recurrente?>">Incidencias - <?= $num_campos ?></div>
        <div class="incidencia_recurrente_<?=$rec->id_recurrente?> hide_rec">
          <?= $mensaje ?>
        </div><br><br>
        <?php } ?>
        <div href="#" class="btn btn-warning imp_rec_btn" style="width: 100%" 
        mostrar="a_detalle_table_<?=$rec->id_recurrente?>">A Detalle <?= abs($num_campos-$total_campos)."/".$total_campos ?></div>
        <div class="a_detalle_table_<?=$rec->id_recurrente?> hide_rec" hidden>
        <table class="table">
        	<?php foreach($rec->campos as $campo){?>
        	<tr>
        		<td><?= $campo->fecha2 ?></td>
        		<td><?= $campo->titulo ?><br><?= $campo->subtitulo ?></td>
        		<td>
        			<?php if($campo->tipo==0&&$campo->lectura=='1'){echo "&#10004;";} ?>
        			<?php if($campo->tipo==0&&$campo->lectura=='0'){echo "X";} ?>
        			<?php if($campo->tipo==1){ echo $campo->lectura; } ?>
        		</td>
        		<td><?= $campo->observacion ?></td>
        	</tr>
        	 <?php } ?>
        </table>
      </div>
      

  <?php } ?>
