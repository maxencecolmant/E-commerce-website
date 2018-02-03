<?php

namespace techdeals;

/**
 * Class Util
 * @package techdeals
 */
class Util {
	
	/**
	 *
	 */
	public static function get_breadcrumb() {
		//$path = explode( "/", $_SERVER['REQUEST_URI'] );
		$path = preg_split( "/\//", $_SERVER['PHP_SELF'], -1, PREG_SPLIT_NO_EMPTY );
		
		$breadcrumb = '<ol class="breadcrumb">';
		
		foreach( $path as $item ) {
			if( $item == end( $path ) ) {
				$breadcrumb .= '<li class="breadcrumb-item active">' . ucfirst( $item ) . '</li>';
			} else {
				$breadcrumb .= '<li class="breadcrumb-item"><a href="/' . $item . '/">' . ucfirst( $item ) . '</a></li>';
			}
		}
		
		$breadcrumb .= '</ol>';
		
		echo $breadcrumb;
	}
	
	/**
	 * @param $mode
	 */
	public static function get_alert( $mode ) {
		if( Session::getInstance()->hasFlashes( $mode ) ) {
			foreach( Session::getInstance()->getFlashes( $mode ) as $type => $value ): ?>
				<?php if( $mode == 'sweet_alert' ) : ?>
					<?php $then = isset( $value['then'] ) ? $value['then'] : null;
					unset( $value['then'] ); ?>
                    <script type="text/javascript">
                        let data = <?php echo json_encode( $value ); ?>;
                        setTimeout(function () {
                            swal(data).then((value) => {
                                switch (value) {
                                    case true:
                                        if (data.buttons != null) {
                                            window.location.href += "&confirm=";
                                        }
                                        break;
                                    default:
                                        break;
                                }
                            })<?php echo $then != null ? $then : '';?>;
                        });
                    </script>
				<?php endif; ?>
				<?php if( $mode == 'default' ) : ?>
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
	
	public static function luhn_validate( $number, $mod5 = false ) {
		$parity = strlen( $number ) % 2;
		$total = 0;
		$digits = str_split( $number );
		foreach( $digits as $key => $digit ) {
			if( ($key % 2) == $parity ) {
				$digit = ($digit * 2);
			}
			
			if( $digit >= 10 ) {
				
				$digit_parts = str_split( $digit );
				
				$digit = $digit_parts[0] + $digit_parts[1];
			}
			$total += $digit;
		}
		
		return ($total % ($mod5 ? 5 : 10) == 0 ? true : false); // If the mod 10 or mod 5 value is equal to zero (0), then it is valid
	}
	
	public static function countCart() {
		$count = 0;
		if( Session::getInstance()->exist( 'cart' ) ) {
			foreach( Session::getInstance()->read( 'cart' ) as $p ) {
				if( is_array( $p ) ) {
					$count++;
				}
			}
		}
		$label = '<span class="badge">' . $count . '</span>';
		
		echo $count > 0 ? $label : '';
	}
	
	public static function getProductSpecs( $id_product ) {
		$specs = Database::getDatabase()->query(
			'SELECT specs_product FROM products WHERE id_product = :id', [
			':id' => $id_product,
		] )->fetch( \PDO::FETCH_COLUMN );
		
		$return = '';
		if( !empty( $specs ) ) {
			$specs = explode( ';', $specs );
			
			foreach( $specs as $spec ) {
				
				if( preg_match( '/=/', $spec ) ) {
					$spec = explode( '=', $spec );
					$return .= '<tr><td>' . ucfirst( $spec[0] ) . '</td><td>' . ucfirst( $spec[1] ) . '</td></tr>';
				}
			}
		}
		
		if(empty(trim($return))) {
		    $return = '<tr><td colspan="2">Aucune Spécification</td></tr>';
        }
		
        return $return;
	}
	
	/**
	 *
	 */
	public static function set_previous_alert() {
		if( Session::getInstance()->hasArgsFlash() ) {
			Session::getInstance()->setFlash( 'sweet_alert', 'success', Session::getInstance()->getArgsFlash() );
		}
	}
	
	/**
	 *
	 */
	public static function sendMail() {
		$validator = new Validator( Session::getInstance(), $_POST );
		if( !empty( $_POST ) ) {
			if( !$validator->hasEmptyFields() ) {
				if( $validator->isEmail( 'email' ) ) {
					$email = htmlspecialchars( $_POST['email'] );
					$message = htmlspecialchars( "Adresse IP: " . Util::get_ip() . "\r\nUser-Agent: " . Util::get_user() . "\r\nEmail: " . $email . "\r \n" . $_POST['message'] . "\r\n" );
					$to = "contact@techdeals.com";
					$headers = "From: <$email>" . "\r\n";
					$subject = "Contact TechDeals :" . $_POST['subject'];
					mail( $to, $subject, $message, $headers );
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
	public static function get_ip() {
		if( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			return (isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	}
	
	/**
	 * @return mixed
	 */
	public static function get_user() {
		if( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return $_SERVER['HTTP_USER_AGENT'];
		}
	}
	
	public static function rmItem( $item ) {
		switch( $item ) {
			case 'category':
				$params = array(
					'table' => 'category_',
					'id_col' => 'id_category',
					'text_alert' => 'la catégorie',
					'text_alert_success' => 'catégorie',
				);
				break;
			case 'products':
				$params = array(
					'table' => 'products',
					'id_col' => 'id_product',
					'text_alert' => 'le produit',
					'text_alert_success' => 'produit',
				);
				break;
			default:
				$params = null;
				break;
		}
		if( !empty( $_GET ) ) {
			if( isset( $_GET['id'] ) && isset( $_GET['action'] ) ) {
				switch( $_GET['action'] ) {
					case 3:
						if( !isset( $_GET['confirm'] ) ) {
							$args = array(
								'title' => 'Supprimer ?',
								'text' => 'Cela supprimera ' . $params['text_alert'] . ' !',
								'icon' => 'warning',
								'buttons' => array(
									'cancel' => 'Annuler',
									'confirm' => 'Supprimer',
								),
								'dangerMode' => true,
							);
							Session::getInstance()->setFlash( 'sweet_alert', 'warning', $args );
						} else {
							Database::getDatabase()->query( 'DELETE FROM ' . $params['table'] . ' WHERE ' . $params['id_col'] . ' = :id', [ ':id' => $_GET['id'] ] );
							$args = array(
								'title' => 'Succès !',
								'text' => 'Votre ' . $params['text_alert_success'] . ' a bien été supprimé !',
								'icon' => 'success',
							);
							Session::getInstance()->setArgsFlash( $args );
							header( "Location: $item.php" );
						}
						break;
					default:
						$args = array(
							'title' => 'Erreur !',
							'text' => 'Cet action n\'existe pas ! ',
							'icon' => 'error',
							'timer' => 3000,
						);
						Session::getInstance()->setFlash( 'sweet_alert', 'error', $args );
						
						break;
				}
			}
		}
	}
	
	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function rmDirR( $dir ) {
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );
		foreach( $files as $file ) {
			(is_dir( "$dir/$file" )) ? Util::rmDirR( "$dir/$file" ) : unlink( "$dir/$file" );
		}
		
		return rmdir( $dir );
	}
}

?>