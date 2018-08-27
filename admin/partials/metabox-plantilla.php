
<table class="form-table">
  <tbody>
	<tr>
		<th>Titulo</th>
		<td><input type="text" name="titulo" value="<?php echo $titulo; ?>"></td>
	</tr>

  <tr>
    <th>Categoria</th>
    <td><input type="text" name="categoria" value="<?php echo $categoria; ?>"></td>
  </tr>

	<tr>
		<th>Post Type:</th>
		<td>
			<select name="sipt" id="">
				<?php foreach (get_post_types(['publicly_queryable' => true], 'objects') as $pt): ?>

					<option value="<?php echo $pt->name; ?>" name='sipt' <?php selected($pt->name, $sipt);?>><?php echo $pt->label; ?></option>
				<?php endforeach?>
			</select>
		</td>
	</tr>

  <tr>
    <th>Elementor a Eliminar</th>
    <td><input type="text" name="delete-elements" value="<?php echo $deleteelements; ?>">
  <p><small>Separe por coma los elementos que desea eliminar.</small></p>
    </td>
  </tr>

  </tbody>
</table>

<!-- <h1>Custom Post Types</h1>
<?php
$datacf = (get_post_meta(get_the_id(), 'sicf', true)) ? get_post_meta(get_the_id(), 'sicf', true) : [];
        ?>
<div style="padding: 10px 0; text-align: right;" ><a  id="add-row-vars" class="button button-primary button-large">+ Agregar Custom Post Type</a></td></div>

  <table id="mytable" class='wp-list-table widefat fixed striped' cellspacing="0" cellpadding="2">

  <tbody>

    <?php foreach ($datacf as $key => $value): ?>
     <tr class="tr-vars">
     	<th>Nombre:</th>
      <td><input type="text" class='cfnombre' name="sicf[<?php echo $key; ?>][cfnombre]" value="<?php echo $value['cfnombre'] ?>" /></td>
      <th>Valor:</th>
      <td><input type="text" class='cfvalor' name="sicf[<?php echo $key; ?>][cfvalor]" value="<?php echo $value['cfvalor'] ?>" /></td>
    </tr>
    <?php endforeach?>
    <?php if (empty($datacf)): ?>
    <tr class="tr-vars">
    	<th>Nombre:</th>
      <td><input type="text" class='cfnombre' name="sicf[0][cfnombre]" /></td>
      <th>Valor:</th>
      <td><input type="text" class='cfvalor' name="sicf[0][cfvalor]" /></td>

    </tr>
    <?php endif?>

    </tbody>
  </table> -->
