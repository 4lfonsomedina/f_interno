<link href='<?= base_url('assets/plugins/fullcalendar-4.1.0');?>/packages/core/main.css' rel='stylesheet' />
<link href='<?= base_url('assets/plugins/fullcalendar-4.1.0');?>/packages/daygrid/main.css' rel='stylesheet' />
<script src='<?= base_url('assets/plugins/fullcalendar-4.1.0');?>/packages/core/main.js'></script>
<script src='<?= base_url('assets/plugins/fullcalendar-4.1.0');?>/packages/interaction/main.js'></script>
<script src='<?= base_url('assets/plugins/fullcalendar-4.1.0');?>/packages/daygrid/main.js'></script>
<script>

 
    
    $(document).ready(function(){
      var loaderC = "<div class='col col-lg-12 loader_ocu'><div class='spinner'>"+
                "<div class='rect1'>"+
                "</div><div class='rect2'>"+
                "</div><div class='rect3'>"+
                "</div><div class='rect4'>"+
                "</div><div class='rect5'>"+
                "</div></div></div>";


      /* CALENDARIO OBJETO */
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        plugins: [ 'interaction', 'dayGrid' ],
        defaultDate: '<?= date('Y-m-d') ?>',
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
        <?php foreach ($actividades1 as $a) { if($a->fecha_fin=='') $a->fecha_fin=date('Y-m-d');?>
          {
            id: '<?= $a->id_actividad ?>',
            title: '<?= $a->actividad ?>',
            start: '<?= $a->fecha_ini ?>',
            <?php foreach($estatus as $e)if($a->estatus==$e->id_estatus){?>
              backgroundColor: '<?= $e->color2 ?>',
              borderColor: '<?= $e->color2 ?>',
            <?php } ?>
          },
        <?php } ?> 
        ],
        /* EVENTO DE CLIK PARA EDITAR*/
        eventClick: function(info) {
          $('#modal_actividades').modal("show");
          $('#modal_actividades_body').html(loaderC);
          $.post($('#base_url').val()+"index.php/sistemas/sistemas/editar_actividad_view/"+info.event.id,function(r){
            $('#modal_actividades_body').html(r);
          })
        },
        
        /* EVENTO DE DRAG PARA CAMBIAR FECHA */
        eventDrop:function(info){
          var fecha_end = new Intl.DateTimeFormat('en-GB').format(info.event.start);
          $.post($('#base_url').val()+"index.php/sistemas/sistemas/fecha_actividad/",{
            id_actividad:info.event.id,
            fecha:fecha_end,
          },function(r){
            $("#fecha_ini_act_"+info.event.id).html(fecha_end);
          })
        },

        /*EVENTO CLICK SOBRE EL DIA*/
        dateClick: function(info) {
          $('#modal_actividades').modal("show");
          $('#modal_actividades_body').html(loaderC);
          $.post($('#base_url').val()+"index.php/sistemas/sistemas/alta_actividad_view/"+$("#acts_departamento").val(),
            {fecha:info.dateStr},
            function(r){
              $('#modal_actividades_body').html(r);
            })
        }
      });
      calendar.render();

      

      $("#actividades_calendario").removeClass('in');
      $("#actividades_calendario").removeClass('active');
    })


</script>