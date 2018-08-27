
<table class="form-table">
  <tbody>
    <tr>
      <th>Tipo de Cola</th>
      <td>
        <select name="type" id="type">
          <option value="add-url" <?php @selected('add-url', $datacola['type'][0]);?>>Importar URLs</option>
          <option value="cola-publicar" <?php @selected('cola-publicar', $datacola['type'][0]);?>>Publicar</option>
        </select>
      </td>
    </tr>

    <tr>
      <th>Fuente:</th>
      <td>
        <select name="source" id="source">
          <option value="url" <?php @selected('url', $datacola['source'][0]);?>>URL</option>
          <option value="from-cola" <?php @selected('from-cola', $datacola['source'][0]);?>>Desde cola</option>
          <option value="manual" <?php @selected('manual', $datacola['source'][0]);?>>Entrada Manual</option>
        </select>
      </td>
    </tr>

    <tr class="tourl-url">
      <th>URL:</th>
      <td>
        <input type="url" name="tourl-url" value='<?php echo (isset($datacola['tourl-url'][0])) ? $datacola['tourl-url'][0] : ''; ?>' placeholder="URL del sitio o sitemap">
      </td>
    </tr>


    <tr class="cola-source">
      <th>Cola:</th>
      <td>
        <select name="cola-source" id="">
          <?php $colas = get_posts(['post_type' => 'colas', 'exclude' => array(get_the_id())]);

        foreach ($colas as $cola) {?>
            <option value="<?php echo $cola->ID; ?>" <?php @selected($cola->ID, $datacola['cola-source'][0]);?>><?php echo $cola->post_title; ?></option>
         <?php }?>


        </select>
      </td>
    </tr>

    <tr class="siplantilla">
      <th>Plantilla a Utilizar:</th>
      <td>
        <select name="siplantilla" id="">
          <?php $plantillas = get_posts(['post_type' => 'siplantillas']);

        foreach ($plantillas as $plantilla) {?>
            <option value="<?php echo $plantilla->ID; ?>" <?php @selected($plantilla->ID, $datacola['siplantilla'][0]);?>><?php echo $plantilla->post_title; ?></option>
         <?php }?>


        </select>
      </td>
    </tr>

  <tr class="tourl-element">
      <th>Elemento CSS:</th>
      <td>
        <input type="text" name="tourl-element" placeholder="loc" value="<?php echo (isset($datacola['tourl-element'][0])) ? $datacola['tourl-element'][0] : ''; ?>">
      </td>
      <th>Atributo:</th>
      <td>
        <input type="text" name="tourl-object" placeholder="plaintext" value="<?php echo (isset($datacola['tourl-object'][0])) ? $datacola['tourl-object'][0] : ''; ?>">
      </td>
  </tr>

  </tbody>
</table>

<script type="text/javascript">


  jQuery(document).ready(function($) {

function hideotros(){

  if ($('#type').val() != 'cola-publicar') {
      $('.siplantilla').hide();
      $('.tourl-element').show();
  }else{
    $('.siplantilla').show();
    $('.tourl-element').hide();
  }


  if ($('#source').val() != 'url') {
      $('.tourl-url').hide();
  }else{
    $('.tourl-url').show();
  }

  if ($('#source').val() != 'from-cola') {
      $('.cola-source').hide();
  }else{
    $('.cola-source').show();
  }


}


   hideotros();

   $('#source, #type').on('change', function(event) {
     event.preventDefault();
    hideotros();
   });
  });
</script>