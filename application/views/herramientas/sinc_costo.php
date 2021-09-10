<div class="panel panel-info">
	<div class="panel-heading">
		productos por sincronizar
	</div>
	
	<div class="panel-body">
	<textarea class="form-control" style="width: 100%" rows="10"><?php foreach($productos as $p)if($p->costo_ulti!=''){ echo "update p_prod set costo_ulti='".$p->costo_ulti."' where producto='".$p->producto."'
";}?></textarea>
	</div>
</div>