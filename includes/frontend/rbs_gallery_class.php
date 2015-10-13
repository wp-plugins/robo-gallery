<?php
/*
*      Robo Gallery     
*      Version: 1.0
*      By Robosoft
*
*      Contact: http://robosoft.co
*      Created: 2015
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2015, Robosoft. All rights reserved.
*      Available only in http://robosoft.co/
*/

class roboGallery extends roboGalleryUtils{

 	public $id = 0;
 	public $options_id = 0;
 	public $real_id = 0;

 	public $returnHtml = '';
 	public $options = array();
 	
 	public $rbsBoxStyle = '';
	public $rbsBoxHoverStyle = '';

	public $rbsOverlayStyle = '';

	public $rbsImageLoadingStyle = '';

	public $rbsLinkIconStyle = '';
	public $rbsLinkIconHoverStyle = '';

	public $rbsZoomIconStyle = '';
	public $rbsZoomIconHoverStyle = '';


	public $rbsTitleStyle = '';
	public $rbsTitleHoverStyle = '';

	public $rbsDescStyle = '';
	public $rbsDescHoverStyle = '';

	public $rbsLightboxStyle = '';
	public $rbsTextLightboxStyle = '';

	public $rbsTitleLightboxStyle = '';

	public $rbsCounterLightboxStyle = '';
	public $rbsCloseLightboxStyle = '';
	public $rbsArrowLightboxStyle = '';




 	public $javaScript = '';
 	public $javaScriptStyle = '';

 	public $galleryId = '';
 	public $helper = '';

 	public $hover 		= 0;
 	public $linkIcon 	= '';
	public $zoomIcon 	= '';
	public $titleHover 	= '';
	public $descHover 	= '';
	public $templateHover = '';

 	public $selectImages = null;
 	
 	public $orderby = 'categoryD';
 	public $thumbsource = 'medium';

 	public $styleList = array();
 	public $scriptList = array();

 	public $thumbClick = 0;

 	function __construct($attr){
 		$this->helper 		= new rbsHelper();
 		$this->galleryId 	= 'rbs_gallery_'.uniqid();
 		
 		if( isset($attr) && isset($attr['id']) ){

			$this->id = $attr['id'];
			$options_id = (int) get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'options', true );
			if($options_id){
				$this->real_id = $this->id;
				$this->options_id = $options_id;
				$this->id = $options_id;
			}
			$this->helper->setId( $this->id );
 		}
 	}
 	
 	function robo_gallery_styles() {
 		if( get_option( ROBO_GALLERY_PREFIX.'jqueryVersion', 'build' )=='forced' ){
 			$this->styleList[] = ROBO_GALLERY_URL.'gallery/css/magnific.css';
 			$this->styleList[] = ROBO_GALLERY_URL.'gallery/css/gallery.css';
 			$this->styleList[] = ROBO_GALLERY_URL.'gallery/css/gallery.utils.css';
 			$this->styleList[] = ROBO_GALLERY_URL.'css/style.css';
 			$this->styleList[] = ROBO_GALLERY_URL.'addons/button/buttons.css';
 		} else {
			wp_enqueue_style( 'robo-gallery-magnific', 	ROBO_GALLERY_URL.'gallery/css/magnific.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
			wp_enqueue_style( 'robo-gallery-gallery', 	ROBO_GALLERY_URL.'gallery/css/gallery.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
			wp_enqueue_style( 'robo-gallery-utils', 	ROBO_GALLERY_URL.'gallery/css/gallery.utils.css',array(), ROBO_GALLERY_VERSION, 'all' );
			wp_enqueue_style( 'robo-gallery-rbs-style', ROBO_GALLERY_URL.'css/style.css', 				array(), ROBO_GALLERY_VERSION, 'all' );
			wp_enqueue_style( 'robo-gallery-rbs-button',ROBO_GALLERY_URL.'addons/button/buttons.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
		}
	}

	function robo_gallery_scripts() { 
		if(  get_option( ROBO_GALLERY_PREFIX.'jqueryVersion', 'build' )=='build'  ){
		
			wp_enqueue_script( 'jquery', false, array(), false, true);
			wp_enqueue_script( 'robo-gallery-evemb', 	ROBO_GALLERY_URL.'gallery/js/jquery.evemb.min.js', 			array( 'jquery' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-utils',  	ROBO_GALLERY_URL.'gallery/js/jquery.utils.min.js', 			array( 'jquery' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-magnific', ROBO_GALLERY_URL.'gallery/js/jquery.magnific.min.js', 		array( 'jquery' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-collage',  ROBO_GALLERY_URL.'gallery/js/jquery.collagePlus.min.js', 	array( 'jquery' ), ROBO_GALLERY_VERSION );   
			wp_enqueue_script( 'robo-gallery-script',  	ROBO_GALLERY_URL.'js/script.js', 							array( 'jquery' ), ROBO_GALLERY_VERSION );   
		
		} else if(get_option( ROBO_GALLERY_PREFIX.'jqueryVersion', 'build' )=='forced') {

			$this->scriptList[] = ROBO_GALLERY_URL.'gallery/js/alt/rbjquer.min.js';
			$this->scriptList[] = ROBO_GALLERY_URL.'gallery/js/alt/jquery.evemb.min.js';
			$this->scriptList[] = ROBO_GALLERY_URL.'gallery/js/alt/jquery.utils.min.js';
			$this->scriptList[] = ROBO_GALLERY_URL.'gallery/js/alt/jquery.magnific.min.js';
			$this->scriptList[] = ROBO_GALLERY_URL.'gallery/js/alt/jquery.collagePlus.min.js';
			$this->scriptList[] = ROBO_GALLERY_URL.'js/alt/script.js';

		} else {

			wp_enqueue_script( 'robo-gallery-rbjquer', 	ROBO_GALLERY_URL.'gallery/js/alt/rbjquer.min.js', 			array( ), 						 ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-evemb', 	ROBO_GALLERY_URL.'gallery/js/alt/jquery.evemb.min.js', 		array( 'robo-gallery-rbjquer' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-utils',  	ROBO_GALLERY_URL.'gallery/js/alt/jquery.utils.min.js', 		array( 'robo-gallery-rbjquer' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-magnific', ROBO_GALLERY_URL.'gallery/js/alt/jquery.magnific.min.js', 	array( 'robo-gallery-rbjquer' ), ROBO_GALLERY_VERSION );
			wp_enqueue_script( 'robo-gallery-collage',  ROBO_GALLERY_URL.'gallery/js/alt/jquery.collagePlus.min.js',array( 'robo-gallery-rbjquer' ), ROBO_GALLERY_VERSION );   
			wp_enqueue_script( 'robo-gallery-script',  	ROBO_GALLERY_URL.'js/alt/script.js', 						array( 'robo-gallery-rbjquer' ), ROBO_GALLERY_VERSION );
		
		}
	}	

	/*
		$hover - 	0   - hover style
					1  	+ hover style
					2   - mainID
	*/
	public function addJavaScriptStyle($styleValue, $styleName = '', $hover='1'){
		if(isset($this->{$styleValue.'Style'}) && $this->{$styleValue.'Style'} ){
			$this->javaScriptStyle.= ($hover!=2?'#'.$this->galleryId.' ':'').$styleName.'{'.$this->{$styleValue.'Style'}.'}';
		}
		if( $hover==1 && isset($this->{$styleValue.'HoverStyle'}) && $this->{$styleValue.'HoverStyle'} ){
			$this->javaScriptStyle.= '#'.$this->galleryId.' '.$styleName.':hover{'.$this->{$styleValue.'HoverStyle'}.'}';
		}
	}

 	

 	public function addBorder($nameOptions = ''){
 		$borderStyle = '';
 		$border = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.$nameOptions, true );
		if( isset($border['width'])){
			$borderStyle.= (int) $border['width'].'px ';
			if($nameOptions=='border-options'){
				$this->helper->setValue( 'borderSize',  (int) $border['width'] );
			}
		}
		if( isset($border['style'])) $borderStyle.=  $border['style'].' ';
		if( isset($border['color'])) $borderStyle.=  $border['color'].' ';
		if( $borderStyle ) return 'border: '.$borderStyle.';';
			else return '';
 	}

 	

 	public function getGallery( ){
 		if( !$this->id ) return ''; 

 		//$galleryImages = get_post_meta( $this->options_id && $this->real_id ? $this->real_id : $this->id, ROBO_GALLERY_PREFIX.'galleryImages', true );;
 		//if( !$galleryImages || !is_array( $galleryImages ) || !count($galleryImages) || !(int)$galleryImages[0] ) return '';

 		$this->helper->setValue( 'filterContainer',  '#'.$this->galleryId.'filter', 'string' );

		
		$sizeType 	= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'sizeType', true );

		$width = 240;  $height = 140;

		$size 		= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'thumb-size-options', true );
		if( count($size) ){
			if( isset($size['width'])  ) 	$width = (int) 	$size['width']; 	else $width = 240;
			if( isset($size['height']) ) 	$height = (int) $size['height']; 	else $height = 140;
		}

		/* robo_gallery */
		if($this->pro){
			$this->getOrderBy($size);
			$this->getSource($size);
		}
		
		/* robo_gallery */
		if($this->pro){ 
			$this->setColumns();
		} else {
			$colums = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'colums', true );
			if(count($colums)){
				$columns = $this->addWidth($colums, 3);
				if( $columns ){
					$columns .= ', {"columnWidth": "auto" , "columns":2 , "maxWidth": 650}, {"columnWidth": "auto" , "columns":3 , "maxWidth": 960}';
					$this->helper->setValue( 'resolutions',  '[ '.$columns .']', 'raw' );
				}
			}
		}

		$radius = (int) get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'radius', true );
		$this->rbsBoxStyle .= ' -webkit-border-radius: '.$radius.'px; -moz-border-radius: '.$radius.'px; border-radius: '.$radius.'px;';

		if( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'border', true ) ){
			$this->rbsBoxStyle .= $this->addBorder('border-options');
			/* robo_gallery */
			if( $this->pro && get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'hover-border', true ) ){
				$this->rbsBoxHoverStyle .= $this->getHoverBorder();
			}
		}

		if( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'shadow', true ) ){
			$this->rbsBoxStyle .=$this->addShadow('shadow-options');
			/* robo_gallery */
			if ( $this->pro && get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'hover-shadow', true ) ){
				$this->rbsBoxHoverStyle .= $this->getHoverShadown();
			}
		}

		$this->thumbClick = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'thumbClick', true );

		
		if($this->options_id){
			$this->id = $this->real_id;
		}
		$this->selectImages = new roboGalleryImages($this->id);
		if($this->options_id){
			$this->id = $this->options_id;
		}


		$this->selectImages->setSize( $width , $height, $this->thumbsource, $this->orderby );

		/* robo_gallery */
		if ( $this->pro ) $this->setCCL();

		$this->selectImages->getImages();

		$this->helper->setOption( 'overlayEffect', 'string');
		$this->helper->setOption( 'boxesToLoadStart', 'int');
		$this->helper->setOption( 'boxesToLoad', 'int');
		$this->helper->setOption( 'lazyLoad', 'bool');
		$this->helper->setOption( 'waitUntilThumbLoads', 'bool');
		$this->helper->setOption( 'waitForAllThumbsNoMatterWhat', 'bool');
		$this->helper->setOption( 'deepLinking', 'bool');
		$this->helper->setOption( 'LoadingWord', 'string');
		$this->helper->setOption( 'loadMoreWord', 'string');

		$loadingBgColor = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'loadingBgColor', true );
		if($loadingBgColor) $this->rbsImageLoadingStyle .=  'background-color: '.$loadingBgColor.';';

		$this->helper->setValue( 'loadMoreClass',  $this->getButtonStyle('button') );

		$this->helper->setOption( 'noMoreEntriesWord', 'string');

		$this->helper->setOption( 'horizontalSpaceBetweenBoxes', 'int');
		$this->helper->setOption( 'verticalSpaceBetweenBoxes', 'int');	

		/* robo_gallery */
		if ( $this->pro ) $this->rbsOverlayStyle .= $this->getOverlayBg();
			else $this->rbsOverlayStyle .= 'background: rgba(7, 7, 7, 0.5);';

		$polaroidOn = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidOn', true );
		if($polaroidOn){
			$polaroidBackground = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidBackground', true );
			$polaroidAlign = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidAlign', true );
			$polaroidStyle = 'text-align:'.$polaroidAlign.'; background: '.$polaroidBackground.';';
		}
		
		$menu = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menu', true );

		$polaroid_template = '';
		$polaroidSource = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidSource', true );
		switch ($polaroidSource) {
			case 'desc':
					$polaroid_template = '@DESC@';
				break;
			case 'caption':
					$polaroid_template = '@CAPTION@';
				break;
			case 'title':
			default:
					$polaroid_template = '@TITLE@';
				break;
		}

		$hover_template = '';
		$desc_template = '';

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'hover', true ) ) $this->hover = 1;
		
		/* robo_gallery */
		if ( $this->pro ) $this->setHoverType();

		$this->linkIcon 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'linkIcon', true ), 'rbsLinkIcon', 1 );
		$this->zoomIcon 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'zoomIcon', true ), 'rbsZoomIcon', 1 , ($this->thumbClick?' rbs-lightbox':'') ); //, ' rbs-lightbox'
		$this->titleHover 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'showTitle', true ), 'rbsTitle', '@TITLE@' );
		
		/* robo_gallery */
		if ( $this->pro ) 	$this->setDescHover();

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocial', true ) ){
			$this->helper->setValue( 'facebook',  	'true', 'raw' );
			$this->helper->setValue( 'twitter',  	'true', 'raw' );
			$this->helper->setValue( 'googleplus',  'true', 'raw' );
			$this->helper->setValue( 'pinterest',  	'true', 'raw' );
		}

		/* robo_gallery */
		if ( $this->pro && method_exists( $this ,'setLightboxBg') ){
			$this->setLightboxBg();
		}
		
		/* v 1.0.2 */
		$lightboxColor = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxColor', true );
		if($lightboxColor) $this->rbsTextLightboxStyle .=  'color: '.$lightboxColor.';';

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxTitle', true )){
			$this->helper->setValue( 'hideTitle',  'true' );
		} 
		

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxCounter', true )){
			$this->rbsCounterLightboxStyle = 'display:none;';
			$this->addJavaScriptStyle('rbsCounterLightbox','.mfp-container .mfp-counter',2);
		}

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxClose', true )){
			$this->rbsCloseLightboxStyle = 'display:none;';
			$this->addJavaScriptStyle('rbsCloseLightbox','.mfp-container .mfp-close',2);
		}

		

		$this->addJavaScriptStyle('rbsBox', '.rbs-img-container');
		$this->addJavaScriptStyle('rbsTitle','.rbsTitle',1);
		$this->addJavaScriptStyle('rbsDesc','.rbsDesc',1);
		$this->addJavaScriptStyle('rbsOverlay','.thumbnail-overlay',0);
		$this->addJavaScriptStyle('rbsLinkIcon','.rbsLinkIcon',1);
		$this->addJavaScriptStyle('rbsZoomIcon','.rbsZoomIcon',1);
		$this->addJavaScriptStyle('rbsImageLoading','.image-with-dimensions',0);

		//$this->addJavaScriptStyle('rbsTitleLightbox','body .mfp-title',2);
		$this->addJavaScriptStyle('rbsTextLightbox','body .mfp-title, body .mfp-counter',2);

		if(count($this->selectImages->imgArray)){

			if( get_option( ROBO_GALLERY_PREFIX.'jqueryVersion', 'build' )=='forced' ){
				$this->robo_gallery_styles();
				$this->robo_gallery_scripts();
			} else {
				add_action( 'get_footer', array($this, 'robo_gallery_styles') );
				add_action( 'get_footer', array($this, 'robo_gallery_scripts') );
			}

			for ($i=0; $i<count($this->selectImages->imgArray); $i++) {
				
				$img = $this->selectImages->imgArray[$i];

				$polaroidDesc =  str_replace( 
					array('@TITLE@','@CAPTION@','@DESC@', '@LINK@'), 
					array( 
						$img['data']->post_title,
						$img['data']->post_excerpt,
						$img['data']->post_content,
						$img['link']
					), 
					$polaroid_template
				);

				$link = $img['image'];

				if( $img['link'] && ( !$this->hover || ( $this->hover == 1 && !$this->linkIcon && !$this->zoomIcon  ) )  ){
					$link = $img['link'].'" data-type="'.($img['typelink']?'blank':'').'link';
				} elseif( $img['videolink'] ) {
					$link = $img['videolink'].'" data-type="iframe';
				}

				$lightboxText = '';

				switch ( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxSource', true ) ) {
					case 'title':
							$lightboxText = $img['data']->post_title;
						break;
					case 'desc':
							$lightboxText = $img['data']->post_content;
						break;
					case 'caption':
							$lightboxText = $img['data']->post_excerpt;
						break;
				}

				$this->returnHtml .= '
					<div class="rbs-img category'.$img['catid'].'" '.( isset($img['col']) && $img['col'] ?' data-columns="'.$img['col'].'" ' :'').'>
			            <div class="rbs-img-image '.(!$this->thumbClick?' rbs-lightbox':'').'" '.( isset($img['effect']) && $img['effect'] ?' data-overlay-effect="'.$img['effect'].'" ' :'').' >
			                <div data-thumbnail="'.$img['thumb'].'" data-width="'.( $sizeType ? $width : $img['sizeW'] ).'" data-height="'.($sizeType?$height:$img['sizeH']).'" ></div>
							<div data-popup="'.$link.'" title="'.$lightboxText.'"></div>
							'.$this->getHover($img).'
			            </div>
						'.($polaroidDesc && $polaroidOn?'<div class="rbs-img-content" '.($polaroidStyle?' style="'.$polaroidStyle.'" ':'').'>'.$polaroidDesc.'</div>':'').'
			        </div>';
			}
		}
		if( $this->returnHtml ){
			$this->returnHtml = 
				($menu?$this->getMenu():'').
				'<div id="'.$this->galleryId.'" data-options="'.$this->galleryId.'" style="width:100%;" class="robo_gallery">'
					. $this->returnHtml
				.'</div>'
				.'<script>'.$this->compileJavaScript().'</script>';

				if(count($this->scriptList)){
					for($i=0;$i<count($this->scriptList);$i++){
						$this->returnHtml .= ' <script type="text/javascript" src="'.$this->scriptList[$i].'"></script>';
					}
				}
				if(count($this->styleList)){
					for($i=0;$i<count($this->styleList);$i++){
						$this->returnHtml .= '<link rel="stylesheet" type="text/css" href="'.$this->styleList[$i].'">';
					}
				}
		} 
		return $this->returnHtml;
 	}


 	function getHover( $img ){
			$hoverHTML = '';
			if(!$this->hover) return $hoverHTML;
			if($this->hover == 1){
				$hoverHTML .= $this->titleHover;
				if( $this->linkIcon || $this->zoomIcon ){
					$hoverHTML .= '<div class="rbsIcons">';
					if($this->linkIcon && $img['link']) $hoverHTML .= '<a href="@LINK@" '.($img['typelink']?'target="_blank"':'').' title="@TITLE@">'.$this->linkIcon.'</a>';
					if($this->zoomIcon) $hoverHTML .= $this->zoomIcon;
					$hoverHTML .= '</div>';
				}
				$hoverHTML .= $this->descHover;
			}

			/* robo_gallery check in class */
			if($this->templateHover) $hoverHTML = $this->templateHover; 

			if($hoverHTML){				
				$hoverHTML =  str_replace( 
					array('@TITLE@','@CAPTION@','@DESC@', '@LINK@', '@VIDEOLINK@'), 
					array( 
						$img['data']->post_title,
						$img['data']->post_excerpt,
						$img['data']->post_content,
						$img['link'],
						$img['videolink'],
					), 
					$hoverHTML
				);
			}
			$hoverHTML = '<div class="thumbnail-overlay">'.$hoverHTML.'</div>'; //.( !$this->zoomIcon ?'rbs-lightbox':'')
			return $hoverHTML;
		}

 	function getMenu(){
 		$retHtml = '';

 		$retHtml .= '<div class="rbs_gallery_button"  id="'.$this->galleryId.'filter">';

 		$paddingLeft = (int)get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'paddingLeft', true );
 		$paddingBottom = (int)get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'paddingBottom', true );
 		$style = '';
 		$style .= 'margin-right:'.$paddingLeft.'px;';
 		$style .= 'margin-bottom:'.$paddingBottom.'px;';
 		
 		$class = $this->getButtonStyle('button');

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menuRoot', true ) ){
			$retHtml .= '<a class="button '.$class.' active" '.($style?'style="'.$style.'"':'').' href="#" data-filter="*">'.get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menuRootLabel', true ).'</a>';
		}
 		
 		for ($i=0; $i < count($this->selectImages->catArray); $i++) { 
 			$category = $this->selectImages->catArray[$i];
 			$retHtml .= '<a href="#" '
 								.' data-filter=".category'.$category['id'].'"'
 								.' class="button '.$class.'"'
 								.' '.($style?'style="'.$style.'"':'')
 							.'>'
 								.$category['title']
 							.'</a>';
 		}
 		$retHtml .= '</div>';
 		return $retHtml;
 	}

 	function getButtonStyle($optionName){
 		$class = '';

 		/* robo_gallery */
 		if ( $this->pro ) $class .= $this->getMenuButton($optionName);
 				else $class = 'button-border-caution ';

 		switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Type', true ) ) {
 			case 'rounded': $class .= 'button-rounded ';break;
 			case 'pill': 	$class .= 'button-pill '; 	break;
 			case 'circle': 	$class .= 'button-circle '; break;
 			case 'normal': default: 					break;
 		}

 		switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Size', true ) ) {
 			case 'jumbo': $class .= 'button-jumbo '; 	break;
 			case 'large': $class .= 'button-large '; 	break;
 			case 'small': $class .= 'button-small '; 	break;
 			case 'tiny': $class .= 'button-tiny '; 		break;
 			case 'normal': default: 					break;
 		}
 		
 		return $class;
 	}
 } 