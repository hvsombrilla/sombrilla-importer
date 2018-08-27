<style>
.cola-dinamica{
	display: none;
}
form#form-manual-input {
	position: relative;
	padding: 20px;
    margin: 0 auto;
    width: 600px;
    max-width: 100%;
}

form#form-manual-input .float-right {
    position: absolute;
    top: 35px;
    right: 21px;
}
form#form-manual-input textarea {
    width: 100%;
}</style>
<form action="" class="wrap" method="POST" id='form-manual-input'>
	<h1>Entrada Manual</h1>
	<div class="float-right">	
		<a href="" class="btn-dynamic page-title-action"><i class="dashicons-before dashicons-admin-settings"></i> Dinámica</a>
	</div>

	<div class="cola-dinamica">
		<table>
			<th>Url*: </th>
			<td><input type="url" id='url' style="width: 300px;"></td>
			<th>Desde: </th>
			<td><input type="text" id='from' placeholder="A" style="width: 30px;"></td>
			<th>Hasta: </th>
			<td><input type="text" id='to' placeholder="Z" style="width: 30px;"></td>
			<td><a href="#" class="generate-dynamic page-title-action"><i class="dashicons-before dashicons-controls-play"></i> Generar</a></td>
		</table>
		<div><small>Use {var} en la URL para reemplazar por el valor dinámico</small></div>
	</div>
	<textarea name="cola-manual" id="cola-manual" cols="30" rows="30"></textarea>
	<label for="">¿A qué cola se agregarán?</label>
		<select name="cola" id="">
          <?php $colas = get_posts(['post_type' => 'colas']);
        foreach ($colas as $cola) {?>
            <option value="<?php echo $cola->ID; ?>" ><?php echo $cola->post_title; ?></option>
         <?php }?>
        </select>
	<input type="submit" class='button button-primary ' value="Agregar a Cola">
</form>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		$('.generate-dynamic').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
			$.post('<?php bloginfo('url'); ?>/?action=getdynurls&token=<?php echo uniqid(); ?>', {url: $('#url').val(), from: $('#from').val(), to: $('#to').val() }, function(data, textStatus, xhr) {
				$('#cola-manual').val(data);
			});
		});


		$('.btn-dynamic').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
			$('.cola-dinamica').toggle();
		});
	});
</script>
