
<div style="padding: 10px 0; text-align: right;" ><a  id="add-row-vars" class="button button-primary button-large">+ Agregar Variable</a></td></div>

  <table id="mytable" class='wp-list-table widefat fixed striped' cellspacing="0" cellpadding="2">
    <thead>
    <tr>
      <td>Variable</td>
      <td>Selector</td>
      <td>Indice</td>
      <td>Objeto</td>
      <td width="30px"></td>
    </tr>
    </thead>
  <tbody>

    <?php foreach ($datavars as $key => $value): ?>
       <tr class="tr-vars">
      <td><input type="text" class='variable' name="vars[<?php echo $key; ?>][variable]" placeholder="titulo" value="<?php echo $value['variable'] ?>" /></td>
      <td><input type="text" class='elemento' name="vars[<?php echo $key; ?>][elemento]" placeholder="h1#title"  value="<?php echo $value['elemento'] ?>" /></td>
      <td><input type="text" class='indice' name="vars[<?php echo $key; ?>][indice]" placeholder="0"  value="<?php echo $value['indice'] ?>" /></td>
      <td><input type="text" class='objeto' name="vars[<?php echo $key; ?>][objeto]" placeholder="plaintext"  value="<?php echo $value['objeto'] ?>" /></td>
      <td><a href="" class="deletevar"><i class="dashicons-before dashicons-trash
"></i></a></td>
    </tr>
    <?php endforeach ?>
     <?php if (empty($datavars)): ?>
    <tr class="tr-vars">
      <td><input type="text" class='variable' name="vars[0][variable]" placeholder="titulo" /></td>
      <td><input type="text" class='elemento' name="vars[0][elemento]" placeholder="h1#title" /></td>
      <td><input type="text" class='indice' name="vars[0][indice]" placeholder="0" /></td>
      <td><input type="text" class='objeto' name="vars[0][objeto]" placeholder="plaintext" /></td>
    </tr>
    <?php endif ?>
    </tbody>
  </table>
<blockquote>
    <h4>Leyenda</h4>
  <p>
    <b>Variable:</b> Nombre de la variable. Podrá luego ser utilizada <small>{nombre}</small>. Solo se aceptan letras minúsculas y guiones.
</p>
<p>
    <b>Selector:</b> Selector CSS del elemento. Ejemplos: <small>h1</small>, <small>h2.title a</small>, <small>div#contenido</small> .
</p>

<p>
    <b>Indice:</b> Numero de índice del elemento. Inicia contando en 0.
</p>

<p>
    <b>Objeto:</b> Atributo que desea extraer. Posibles valores adicionales: <b>innertext</b>, <b>outtertext</b>, <b>plaintext</b>. Valor por defecto: plaintext.
</p>
</blockquote>
<script type="text/javascript">
    jQuery(document).ready(function() {

      $('body').on('click', '.deletevar', function(event) {
        event.preventDefault();
        console.log('diste');
        /* Act on the event */
        $(this).closest('tr').remove();
      });

      var lastid = <?php echo count($datavars); ?>;
        $("#add-row-vars").click(function() {
          $('#mytable tbody>tr:last').clone(true).insertAfter('#mytable tbody>tr:last');


$('#mytable tbody>tr:last input.elemento').attr('name', 'vars['+ lastid + '][elemento]');

$('#mytable tbody>tr:last input.indice').attr('name', 'vars['+ lastid + '][indice]');

$('#mytable tbody>tr:last input.objeto').attr('name', 'vars['+ lastid + '][objeto]');

$('#mytable tbody>tr:last input.variable').attr('name', 'vars['+ lastid + '][variable]');
lastid++;

          return false;
        });
    });


</script>