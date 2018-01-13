<?php

namespace techdeals;

/**
 * Class Util
 * @package techdeals
 */
class Util
{
    
    /**
     *
     */
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
    
    /**
     * @param $mode
     */
    static function get_alert ($mode)
    {
        if (Session::getInstance()->hasFlashes($mode)) {
            foreach (Session::getInstance()->getFlashes($mode) as $type => $value): ?>
                <?php if ($mode == 'sweet_alert') : ?>
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
                <?php endif; ?>
                <?php if ($mode == 'default') : ?>
                    <div class="alert alert-<?php echo $type; ?> alert-dismissible show" role="alert">
                        <ul>
                            <?php echo $value; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach;
        }
    }
    
    /**
     *
     */
    static function set_previous_alert ()
    {
        if (Session::getInstance()->hasArgsFlash()) {
            Session::getInstance()->setFlash('sweet_alert', 'success', Session::getInstance()->getArgsFlash());
        }
    }
    
    /**
     * @param $dir
     * @return bool
     */
    static function rmDirR ($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? Util::rmDirR("$dir/$file") : unlink("$dir/$file");
        }
        
        return rmdir($dir);
    }
    
    /**
     *
     */
    static function sendMail ()
    {
        $validator = new Validator(Session::getInstance(), $_POST);
        if (!empty($_POST)) {
            if (!$validator->hasEmptyFields()) {
                if ($validator->isEmail('email')) {
                    $email = htmlspecialchars($_POST['email']);
                    $message = htmlspecialchars("Adresse IP: " . Util::get_ip() . "\r\nUser-Agent: " . Util::get_user() . "\r\nEmail: " . $email . "\r \n" . $_POST['message'] . "\r\n");
                    $to = "contact@techdeals.com";
                    $headers = "From: <$email>" . "\r\n";
                    $subject = "Contact TechDeals :" . $_POST['subject'];
                    mail($to, $subject, $message, $headers);
                } else {
                    $validator->showErrors();
                }
            } else {
                $validator->showErrors();
            }
        }
    }
    
    /**
     * @return string
     */
    static function get_ip ()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }
    }
    
    /**
     * @return mixed
     */
    static function get_user ()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return $_SERVER['HTTP_USER_AGENT'];
        }
    }
}

?>