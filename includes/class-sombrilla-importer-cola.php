<?php

/**
 * This Class proccess the queue
 */
class Sombrilla_Importer_Cola
{
    public function __construct()
    {
        add_action('init', [$this, 'proccessCola']);
    }

    public function proccessCola()
    {
        if (isset($_GET['action']) and $_GET['action'] == 'getdynurls') {

            foreach (range($_POST['from'], $_POST['to']) as $valor) {
                echo str_ireplace('{var}', $valor, $_POST['url']) . "\n";
            }

            exit();
        }

        if (isset($_POST['cola-manual'])) {

            foreach (explode("\n", $_POST['cola-manual']) as $urltoinsert) {
                $this->addUrl(trim($urltoinsert), trim($_POST['cola']), false);
            }
        }

        if (isset($_REQUEST['runcola'])) {
            $cola     = $_REQUEST['runcola'];
            $postmeta = get_post_meta($cola);
            $type     = $postmeta['type'][0];

            $source = $postmeta['source'][0];

            if ($source == 'from-cola') {
                $sourcecola = $postmeta['cola-source'][0];
                $url        = $this->getLastFromCola($sourcecola);
                if (empty($url)) {
                    exit('done');
                }
                $this->deleteFromCola($url);
            } else {
                $url = $postmeta['tourl-url'][0];
            }

            if ($type == 'cola-publicar') {
                $siplantilla = $postmeta['siplantilla'][0];
                $this->generarPost($url, $siplantilla);

            } else {

                $vars = [];

                if (!empty($postmeta['tourl-element'][0])) {
                    $vars['element'] = $postmeta['tourl-element'][0];
                }

                if (!empty($postmeta['tourl-object'][0])) {
                    $vars['object'] = $postmeta['tourl-object'][0];
                }

                $html = str_get_html($this->curl_download($url));
                $urls = $this->getDomElement($html, $vars, false);

                foreach ($urls as $urltoinsert) {
                    $this->addUrl($urltoinsert, $cola);
                }

            }

            exit();

        }

    }

    public function getDomElement($html, $args, $single = true)
    {

        $element = (!empty($args['element'])) ? $args['element'] : 'body';
        $index   = (!empty($args['index'])) ? $args['index'] : 0;
        $object  = (!empty($args['object'])) ? $args['object'] : 'plaintext';

        if ($single == true) {

            $return = @$html->find($element, $index)->{$object};

        } else {
            $return = [];

            $allelements = $html->find($element);

            foreach ($allelements as $eachelement) {
                $return[] = $eachelement->{$object};
            }
        }

        return $return;
    }

    public function isurlprocessed($url)
    {
        global $wpdb;
        return $wpdb->get_var("SELECT status FROM {$wpdb->prefix}cola WHERE url = {$url}");

    }

    public function getLastFromCola($cola)
    {
        global $wpdb;
        return $wpdb->get_var("SELECT url FROM {$wpdb->prefix}cola WHERE cola = {$cola} AND status = 0 ORDER BY id ASC LIMIT 1");
    }
    public function deleteFromCola($url)
    {
        global $wpdb;
        $wpdb->update($wpdb->prefix . 'cola', ['status' => 1], ['url' => $url]);
        return;
    }
    public function getLastPostDate()
    {
        $post = get_posts(array('post_status' => 'any', 'numberposts' => 1));
        if (!empty($post[0]->post_date)) {
            return strtotime(date($post[0]->post_date));
        }
        return time();
    }

    public function curl_download($url)
    {
        if (!function_exists('curl_init')) {
            die('Sorry cURL is not installed!');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0." . rand(1000, 4000) . ".84 Safari/537.36");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function addUrl($url, $cola, $echo = true)
    {
        global $wpdb;

        if (filter_var($url, FILTER_VALIDATE_URL) == false) {
            return;
        }

        $table  = $wpdb->prefix . 'cola';
        $data   = array('url' => trim($url), 'cola' => $cola);
        $format = array('%s', '%d');
        $wpdb->insert($table, $data, $format);

        if ($echo) {
            echo '<tr><td>URL Agregada a la cola ' . get_the_title($cola) . ': ' . $url . '</td></tr>';
        }

    }

    public function asignarCategoria($name)
    {
        global $wpdb;

        $new_term_data = array(
            'name'       => $name,
            'slug'       => sanitize_title($name),
            'term_group' => 0,
        );

        $wpdb->insert($wpdb->terms, $new_term_data);

        $tid     = $wpdb->insert_id;
        $termtax = array(
            'term_id'  => $tid,
            'taxonomy' => 'category',
        );

        $wpdb->insert($wpdb->term_taxonomy, $termtax);

        return $tid;

    }

    public function generarPost($url, $plantilla)
    {

        $html = str_get_html($this->curl_download($url));

        $seconds  = rand(300, 600);
        $date_now = $this->getLastPostDate();

        $fecha = date("Y-m-d H:i:s", ($date_now + $seconds));

        foreach (explode(',', get_post_meta($plantilla, 'delete-elements', true)) as $elemento) {
            foreach ($html->find($elemento) as $item) {
                $item->outertext = '';
            }
        }

        $datavars    = (get_post_meta($plantilla, 'vars', true)) ? get_post_meta($plantilla, 'vars', true) : [];
        $datareplace = (get_post_meta($plantilla, 'sireplace', true)) ? get_post_meta($plantilla, 'sireplace', true) : [];
        $search      = [];
        $replace     = [];

        $vars = [];

        foreach ($datavars as $variable) {
            $search[]   = '{' . $variable['variable'] . '}';
            $args       = ['element' => $variable['elemento'], 'index' => $variable['indice'], 'object' => $variable['objeto']];
            $valordevar = $this->getDomElement($html, $args, true);

            $valordevar = apply_filters('si-vars-before-replace', $valordevar, $variable['variable'], $plantilla);

            foreach ($datareplace as $reemplazo) {
                if ($variable['variable'] == $reemplazo['subject'] or $reemplazo['subject'] == 'all') {
                    $valordevar = str_ireplace($reemplazo['search'], $reemplazo['replace'], $valordevar);

                }
            }

            $valordevar = apply_filters('si-vars-after-replace', $valordevar, $variable['variable'], $plantilla);
            $replace[]  = $valordevar;

            $vars[$variable['variable']] = $valordevar;
            unset($args);
        }

        $titulo = get_post_meta($plantilla, 'titulo', true);

        $pt      = (!empty(get_post_meta($plantilla, 'sipt', true))) ? get_post_meta($plantilla, 'sipt', true) : 'post';
        $content = get_post_field('post_content', $plantilla);
        // Create post object

        $my_post = array(
            'post_title'   => htmlspecialchars_decode(str_ireplace($search, $replace, $titulo)),
            'post_content' => htmlspecialchars_decode(str_ireplace($search, $replace, $content)),
            'post_type'    => $pt,
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
        );

        $post_id = wp_insert_post($my_post);

        do_action('si_after_publish', $post_id, $vars);

        if (!empty(get_post_meta($plantilla, 'categoria', true))) {

            $categorianame = get_post_meta($plantilla, 'categoria', true);
            $categorianame = str_ireplace($search, $replace, $categorianame);

            if (term_exists($categorianame, 'category')) {
                $categoriaid = get_cat_ID(str_ireplace($search, $replace, $categorianame));
            } else {
                $catarr      = [];
                $categoriaid = $this->asignarCategoria($categorianame);
            }

            wp_set_post_categories($post_id, $categoriaid, false);

        }

        update_post_meta($post_id, "source", $url);
        echo '<tr><td>Se ha Publicado: <a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a></td></tr>';

    }
}
