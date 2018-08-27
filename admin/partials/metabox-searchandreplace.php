
<div style="padding: 10px 0; text-align: right;" ><a  id="add-row-replace" class="button button-primary button-large">+ Agregar Nuevo</a></td></div>
  <table id="table-replaces" class='wp-list-table widefat fixed striped' cellspacing="0" cellpadding="2">

  <tbody>

    <?php foreach ($datareplace as $key => $value): ?>
       <tr class="tr-vars">

        <td>Buscar <input type="text" class='search' name="sireplace[<?php echo $key; ?>][search]" value="<?php echo $value['search'] ?>" />

         y Reemplazar por <input type="text" class='replace' name="sireplace[<?php echo $key; ?>][replace]" value="<?php echo $value['replace'] ?>" /> en 

        <select name="sireplace[<?php echo $key; ?>][subject]" class="subject" >
          <option value="all" <?php selected('all', $value['subject']); ?>>Todas las Variables</option>
          <?php foreach ($datavars as $variables): ?>
              <option value="<?php echo $variables['variable']; ?>" <?php selected($variables['variable'], $value['subject']); ?>><?php echo $variables['variable']; ?></option>
          <?php endforeach ?>
        </select>

      </td>
     <td width="20px"><a href="" class="deletesar"><i class="dashicons-before dashicons-trash
"></i></a></td>
    </tr>
    <?php endforeach ?>
     <?php if (empty($datareplace)): ?>
     <tr class="tr-vars">

        <td>Buscar <input type="text" class='search' name="sireplace[0][search]" />

         y Reemplazar por <input type="text" class='replace' name="sireplace[0][replace]" /> en 

        <select name="sireplace[0][subject]" class="subject">
          <option value="all" >Todas las Variables</option>
          <?php foreach ($datavars as $variables): ?>
              <option value="<?php echo $variables['variable']; ?>"><?php echo $variables['variable']; ?></option>
          <?php endforeach ?>
        </select>

      </td>
     
    </tr>
    <?php endif ?>
    </tbody>
  </table>

<script type="text/javascript">
    jQuery(document).ready(function() {

      $('body').on('click', '.deletesar', function(event) {
        event.preventDefault();
        /* Act on the event */
        $(this).closest('tr').remove();
      });

      var lastid = <?php echo count($datavars); ?>;
        $("#add-row-replace").click(function() {
          $('#table-replaces tbody>tr:last').clone(true).insertAfter('#table-replaces tbody>tr:last');


$('#table-replaces tbody>tr:last input.search').attr('name', 'sireplace['+ lastid + '][search]');

$('#table-replaces tbody>tr:last input.replace').attr('name', 'sireplace['+ lastid + '][replace]');

$('#table-replaces tbody>tr:last select.subject').attr('name', 'sireplace['+ lastid + '][subject]');


lastid++;

          return false;
        });
    });


</script>