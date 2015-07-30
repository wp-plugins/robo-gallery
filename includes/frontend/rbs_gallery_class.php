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



if( file_exists( WP_PLUGIN_DIR.'/robogallerykey/robogallerykey.php') ){
	include_once( WP_PLUGIN_DIR.'/robogallerykey/robogallerykey.php' );
} else {
	class roboGalleryParent{ public $pro = 0; }
}


class roboGallery extends roboGalleryParent{

 	public $id = 0;

 	public $returnHtml = '';
 	public $options = array();
 	
 	public $rbsBoxStyle = '';
	public $rbsBoxHoverStyle = '';

	public $rbsOverlayStyle = '';

	public $rbsImageLoadingStyle = '';
	

	public $linkIconStyle = '';
	public $linkIconHoverStyle = '';
	
	public $zoomIconStyle = '';
	public $zoomIconHoverStyle = '';

	public $rbsTitleStyle = '';
	public $rbsTitleStyleHover = '';

	public $rbsDescStyle = '';
	public $rbsDescHoverStyle = '';

 	public $javaScript = '';
 	public $javaScriptStyle = '';

 	public $galleryId = '';
 	public $helper = '';

 	public $hover 		=0;
 	public $linkIcon 	='';
	public $zoomIcon 	='';
	public $titleHover 	='';
	public $descHover 	='';
	public $templateHover = '';

 	public $selectImages = null;
 	
 	public $orderby = 'categoryD';
 	public $thumbsource = 'medium';

 	function __construct($attr){
 		$this->helper 		= new rbsHelper();
 		$this->galleryId 	= 'rbs_gallery_'.uniqid();
 		
 		if( isset($attr) && isset($attr['id']) ){
			$this->id = $attr['id'];
			$this->helper->setId( $this->id );
 		}
 	}
 	
 	function robo_gallery_styles() {
		wp_enqueue_style( 'robo-gallery-magnific', 	ROBO_GALLERY_URL.'gallery/css/magnific.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
		wp_enqueue_style( 'robo-gallery-gallery', 	ROBO_GALLERY_URL.'gallery/css/gallery.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
		wp_enqueue_style( 'robo-gallery-utils', 	ROBO_GALLERY_URL.'gallery/css/gallery.utils.css',array(), ROBO_GALLERY_VERSION, 'all' );
		wp_enqueue_style( 'robo-gallery-rbs-style', ROBO_GALLERY_URL.'css/style.css', 				array(), ROBO_GALLERY_VERSION, 'all' );
		wp_enqueue_style( 'robo-gallery-rbs-button',ROBO_GALLERY_URL.'addons/button/buttons.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
	}

	function robo_gallery_scripts() {
		wp_enqueue_script( 'jquery', false, array(), false, true);
		wp_enqueue_script( 'robo-gallery-evemb', 	ROBO_GALLERY_URL.'gallery/js/jquery.evemb.min.js', 			array( 'jquery' ), ROBO_GALLERY_VERSION );
		wp_enqueue_script( 'robo-gallery-utils',  	ROBO_GALLERY_URL.'gallery/js/jquery.utils.min.js', 	array( 'jquery' ), ROBO_GALLERY_VERSION );
		wp_enqueue_script( 'robo-gallery-magnific', ROBO_GALLERY_URL.'gallery/js/jquery.magnific.min.js', array( 'jquery' ), ROBO_GALLERY_VERSION );
		wp_enqueue_script( 'robo-gallery-collage',  ROBO_GALLERY_URL.'gallery/js/jquery.collagePlus.min.js', 		array( 'jquery' ), ROBO_GALLERY_VERSION );   
		wp_enqueue_script( 'robo-gallery-script',  	ROBO_GALLERY_URL.'js/script.js', 							array( 'jquery' ), ROBO_GALLERY_VERSION );   
		
	}	

	public function addJavaScriptStyle($styleValue, $styleName = '', $hover='1'){
		if(isset($this->{$styleValue.'Style'}) && $this->{$styleValue.'Style'} ){
			$this->javaScriptStyle.= '#'.$this->galleryId.' '.$styleName.'{'.$this->{$styleValue.'Style'}.'}';
		}
		if( $hover && isset($this->{$styleValue.'HoverStyle'}) && $this->{$styleValue.'HoverStyle'} ){
			$this->javaScriptStyle.= '#'.$this->galleryId.' '.$styleName.':hover{'.$this->{$styleValue.'HoverStyle'}.'}';
		}
	}

 	public function addWidth( $colums, $index ){
 		$ret = array();
		if( isset($colums['autowidth'.$index]) ){
			$ret[] = '"columnWidth": "auto"';
			if($colums['colums'.$index]) $ret[] =  '"columns":'.$colums['colums'.$index];
		} elseif($colums['width'.$index]){
			$ret[] = '"columnWidth": '.$colums['width'.$index];
		}
		if( count($ret) ){
			switch ($index) {
				case '1': $r = '960'; break;
				case '2': $r = '650'; break;
				case '3': $r = '450'; break;
			}
			$ret[] = '"maxWidth": '.$r;
			return '{'.implode( ' , ', $ret ).'}';
		} else return '';
 	}

 	public function addBorder($nameOptions = ''){
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

 	public function addShadow($nameOptions = ''){
 		$shadow = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.$nameOptions, true );
 		
		if( isset($shadow['hshadow'])) 	$shadowStyle.= (int) $shadow['hshadow'].'px ';

		if( isset($shadow['vshadow'])) 	$shadowStyle.= (int) $shadow['vshadow'].'px ';

		if( isset($shadow['bshadow'])) 	$shadowStyle.= (int) $shadow['bshadow'].'px ';

		if( isset($shadow['color'])) 	$shadowStyle.=  $shadow['color'].' ';
		//echo $shadowStyle;
		if( $shadowStyle ){
			return 	'-webkit-box-shadow:'.$shadowStyle.';'.
					'-moz-box-shadow: 	'.$shadowStyle.';'.
					'-o-box-shadow: 	'.$shadowStyle.';'.
					'-ms-box-shadow: 	'.$shadowStyle.';'.
					'box-shadow: 		'.$shadowStyle.';';
		} else return '';

 	}
 	
 	function getTemplateItem( $item, $class = '', $template = '', $addClass = '' ){
		$retHtml = ''; 
		if(count($item)){
			if( isset($item[enabled]) && $item[enabled] ){
				if(isset($item['fontSize'])) 		$this->{$class.'Style'} .= ' font-size:'.       (int)$item['fontSize'].'px;'
																			  .' '; 
				if(isset($item['color'])) 			$this->{$class.'Style'} .= ' color:'.			$item['color'].';';
				if(isset($item['fontBold'])) 		$this->{$class.'Style'} .= ' font-weight:'.		($item['fontBold']		?'bold'		:'normal').';';
				if(isset($item['fontItalic'])) 	 	$this->{$class.'Style'} .= ' font-style:'.		($item['fontItalic']	?'italic'	:'normal').';';
				if(isset($item['fontUnderline'])) 	$this->{$class.'Style'} .= ' text-decoration:'.	($item['fontUnderline'] ?'underline':'none').';';
				if(isset($item['colorHover'])) 		$this->{$class.'HoverStyle'} .= 'color:'.$item['colorHover'].';';

				if( $template==1 ){
					if(isset($item['colorBg'])) 	$this->{$class.'Style'} .= 'background:'.$item['colorBg'].';';
					if(isset($item['color']) && isset($item['borderSize']) && $item['borderSize'])
													$this->{$class.'Style'} .= 'border:'.(int)$item['borderSize'].'px solid '.$item['color'].';';
					if(isset($item['colorHover']) && isset($item['borderSize']) && $item['borderSize'])		
													$this->{$class.'HoverStyle'} .= 'border:'.(int)$item['borderSize'].'px solid '.$item['colorHover'].';';
					if(isset($item['colorBgHover']))$this->{$class.'HoverStyle'} .= 'background:'.$item['colorBgHover'].';';
				}
				if($template==1){
					$retHtml .= '<i class="fa '.$item['iconSelect'].' '.$class.' '.$addClass.'" ></i>';
				} else {
					$retHtml .= '<div class="'.$class.' '.$addClass.'">'.$template.'</div>';
				}
			}
		}
		return $retHtml;
	}

 	public function compileJavaScript(){
 		$javaScript = '';
 		$javaScript .= 
 		'var '.$this->galleryId.' = {'.$this->helper->getOptionList().'}, '.$this->galleryId.'_css = "'.$this->javaScriptStyle.'",
		head = document.head || document.getElementsByTagName("head")[0],
		style = document.createElement("style");
		style.type = "text/css";
		if (style.styleSheet) style.styleSheet.cssText = '.$this->galleryId.'_css;
			else  style.appendChild(document.createTextNode('.$this->galleryId.'_css));
		head.appendChild(style);';
		return $javaScript;
 	}

 	public function getThumbParams( ){

 	}

 	public function getGallery( ){
 		if( !$this->id ) return ''; 
 		
 		$galleryImages = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'galleryImages', true );;
 		if( !$galleryImages || !is_array( $galleryImages ) || !count($galleryImages) || !(int)$galleryImages[0] ) return '';

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
		
		$colums = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'colums', true );
		if(count($colums)){
			if( isset($colums['autowidth']) ){
				if($colums['colums']) $this->helper->setValue( 'columns',  $colums['colums'], 'int' );
				$this->helper->setValue( 'columnWidth', 'auto' );
			} elseif($colums['width']){ 
				$this->helper->setValue( 'columnWidth',  $colums['width'], 'int' );
			}
			$resolutions=array( $this->addWidth($colums, 1), $this->addWidth($colums, 2), $this->addWidth($colums, 3) );
			if( count($resolutions) ){
				$this->helper->setValue( 'resolutions',  '['.implode( ' , ', $resolutions ).']', 'raw' );
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
		
		$this->selectImages = new roboGalleryImages($this->id);
		$this->selectImages->setSize( $width , $height, $this->thumbsource, $this->orderby );
		$this->selectImages->getImages();

		$this->helper->setOption( 'overlayEffect', 'string');
		$this->helper->setOption( 'boxesToLoadStart', 'int');
		$this->helper->setOption( 'boxesToLoad', 'int');
		$this->helper->setOption( 'lazyLoad', 'bool');
		$this->helper->setOption( 'waitUntilThumbLoads', 'bool');
		$this->helper->setOption( 'waitForAllThumbsNoMatterWhat', 'bool');
		$this->helper->setOption( 'LoadingWord', 'string');
		$this->helper->setOption( 'loadMoreWord', 'string');

		$loadingBgColor = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'loadingBgColor', true );
		if($loadingBgColor) $this->rbsImageLoadingStyle .=  'background-color: '.$loadingBgColor;

		$this->helper->setValue( 'loadMoreClass',  $this->getButtonStyle('button') );

		$this->helper->setOption( 'noMoreEntriesWord', 'string');

		$this->helper->setOption( 'horizontalSpaceBetweenBoxes', 'int');
		$this->helper->setOption( 'verticalSpaceBetweenBoxes', 'int');
		
		/* robo_gallery */
		if ( $this->pro ) $this->rbsOverlayStyle .= $this->getOverlayBg();
			else $this->rbsOverlayStyle .= 'background: rgb(255, 255, 255)';

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
		$this->zoomIcon 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'zoomIcon', true ), 'rbsZoomIcon', 1 ); //, ' rbs-lightbox'
		$this->titleHover 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'showTitle', true ), 'rbsTitle', '@TITLE@' );
		
		/* robo_gallery */
		if ( $this->pro ) 	$this->setDescHover();

		$this->addJavaScriptStyle('rbsBox', '.rbs-img-container');
		$this->addJavaScriptStyle('rbsTitle','.rbsTitle',1);
		$this->addJavaScriptStyle('rbsDesc','.rbsDesc',1);
		$this->addJavaScriptStyle('rbsOverlay','.thumbnail-overlay',0);
		$this->addJavaScriptStyle('rbsLinkIcon','.rbsLinkIcon',1);
		$this->addJavaScriptStyle('rbsZoomIcon','.rbsZoomIcon',1);
		$this->addJavaScriptStyle('rbsImageLoading','.image-with-dimensions',0);

		if(count($this->selectImages->imgArray)){
			$this->robo_gallery_styles();
			$this->robo_gallery_scripts();

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
				/*class="rbs-lightbox"*/
				//echo $img['effect'];
				$this->returnHtml .= '
					<div class="rbs-img category'.$img['catid'].'" '.( isset($img['col']) && $img['col'] ?' data-columns="'.$img['col'].'" ' :'').'>
			            <div class="rbs-img-image rbs-lightbox" '.( isset($img['effect']) && $img['effect'] ?' data-overlay-effect="'.$img['effect'].'" ' :'').' >
			                <div data-thumbnail="'.$img['thumb'].'" data-width="'.( $sizeType ? $width : $img['sizeW'] ).'" data-height="'.($sizeType?$height:$img['sizeH']).'" ></div>
							<div data-popup="'.( $img['videolink'] ? $img['videolink'].'" data-type="iframe' : $img['image'] ).'" title="'.$img['data']->post_title.'"></div>
							'.$this->getHover($img).'
			            </div>
						'.($polaroidDesc && $polaroidOn?'<div class="rbs-img-content" '.($polaroidStyle?' style="'.$polaroidStyle.'" ':'').'>'.$polaroidDesc.'</div>':'').'
			        </div>';
			}//class="'.(!$this->hover|| 2==3?' rbs-lightbox':'').'"    //data-overlay-effect="push-up"
		}
		if( $this->returnHtml ){
			$this->returnHtml = 
				($menu?$this->getMenu():'').
				'<div id="'.$this->galleryId.'" data-options="'.$this->galleryId.'" style="width:100%;" class="robo_gallery">'
					. $this->returnHtml
				.'</div>'
				.'<script>'.$this->compileJavaScript().'</script>';
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