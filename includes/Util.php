<?php

class Util
{
    
    static function get_breadcrumb ()
    {
        //$path = explode( "/", $_SERVER['REQUEST_URI'] );
        $path = preg_split("/\//", $_SERVER['PHP_SELF'], -1, PREG_SPLIT_NO_EMPTY);
        
        $breadcrumb = '<ol class="breadcrumb">';
        
        foreach ($path as $item) {
            if ($item == end($path)) {
                $breadcrumb .= '<li class="breadcrumb-item active">' . ucfirst($item) . '</li>';
            } else {
                $breadcrumb .= '<li class="breadcrumb-item"><a href="">' . ucfirst($item) . '</a></li>';
            }
        }
        
        $breadcrumb .= '</ol>';
        
        echo $breadcrumb;
    }
    
    static function get_alert ()
    {
        if (Session::getInstance()->hasFlashes()) {
            foreach (Session::getInstance()->getFlashes() as $mode => $values): ?>
                <?php if ($mode == 'sweet_alert') : ?>
                    <?php foreach ($values as $value) : ?>
                        <script type="text/javascript">
                            let data = <?php echo json_encode($value); ?>;
                            setTimeout(function () {
                                swal(data).then((value) => {
                                        switch (value) {
                                            case true :
                                                if (data.buttons != null) {
                                                    window.location.href += "&confirm=";
                                                }
                                                break;
                                            default:
                                                break;
                                        }
                                    });
                            });
                        </script>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach;
        }
    }
    
    static function set_previous_alert() {
        if (Session::getInstance()->hasArgsFlash()) {
            Session::getInstance()->setFlash('sweet_alert', 'success', Session::getInstance()->getArgsFlash());
        }
    }
}

?>