<?php 

class PagesController {

    public function E404() {
        // ob_start();
        // include('views/404.php');
        // $out = ob_get_contents();
        // ob_end_clean();
        // return $out;
        include('views/404.php');
    }

}