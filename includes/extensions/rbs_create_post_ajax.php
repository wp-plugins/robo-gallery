<?php
if ( ! defined( 'WPINC' ) )  die;

rbs_gallery_include('class.postcontroller.php', ROBO_GALLERY_EXTENSIONS_PATH);


if(!function_exists('rbs_ajax_create_article')){
	function rbs_ajax_create_article(){
		if( 
				isset($_POST['galleryid']) && (int)$_POST['galleryid'] && 
				isset($_POST['categoryid']) && (int)$_POST['categoryid'] 
		){
			$galleryid = intval( $_POST['galleryid'] );
			$categoryid = intval( $_POST['categoryid'] );

			$post_info = get_post( $galleryid );
			
			if( gettype($post_info)!='object' ) {
				echo '<p><strong>'.__('Post not created. Error: ','rbs_gallery').'</strong><br><p>empty gallery id</p>';
				die();
			}
	
			$Poster = new PostController;
			
			$title = $post_info->post_title;
			if(isset( $_POST['articletitle'] ) && $_POST['articletitle'] ) $title = wp_kses_data($_POST['articletitle']);
			
			$Poster->set_title( $title );
			$Poster->add_category( array($categoryid) );
			$Poster->set_type( "post" );
			$Poster->set_content( '[robo-gallery id="'.$galleryid.'"]' );
			$Poster->set_author_id( get_current_user_id() );
			$Poster->set_post_slug( 'post_'.$post_info->post_name );
			$Poster->set_post_state( "publish" );
			$Poster->create();

			if( isset($Poster->errors) && count($Poster->errors) ){
				echo '<p><strong>'.__('Post not created. Error: ','rbs_gallery').'</strong><br>';
				for ($i=0; $i < count($Poster->errors); $i++) { 
					$error = $Poster->errors[$i];
					echo ' &nbsp;&nbsp; - '.$error.'<br>';
				}
				echo '</p>';
			} else {
				echo '<p>'.__('Post created','rbs_gallery').'</p>';  
			}
		} else {
			echo '<p><strong>'.__('Error: input value','rbs_gallery').'</strong></p>';
		}
		die();
	}
}

if(!function_exists('rbs_ajax_create_article_form')){
	function rbs_ajax_create_article_form(){ 
		$args = array(
			'show_option_all'    => '',
			'show_option_none'   => '',
			'option_none_value'  => '-1',
			'orderby'            => 'ID', 
			'order'              => 'ASC',
			'show_count'         => 0,
			'hide_empty'         => 0, 
			'child_of'           => 0,
			'exclude'            => '',
			'echo'               => 1,
			'selected'           => 0,
			'hierarchical'       => 1, 
			'name'               => 'cat',
			'id'                 => 'rbs_post_create_category',
			'class'              => 'form-control',
			'depth'              => 0,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false,
			'value_field'	     => 'term_id',	
		);
		if( !isset($_POST['galleryid']) || !(int)$_POST['galleryid'] ){
			echo '<p><strong>'.__('Post not created. Error: ','rbs_gallery').'</strong><br><p>'._e('Empty  gallery ID','rbs_gallery').'</p>';
			return ;
		} ; 
		
		$post_info = get_post( (int) $_POST['galleryid'] );

		if( gettype($post_info)!='object' ) {
			echo '<p><strong>'.__('Post not created. Error: ','rbs_gallery').'</strong><br><p>'._e('Incorrect  gallery ID','rbs_gallery').'</p>';
			return ;
		}

		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="rbs_post_create_title"><?php _e('Select category','rbs_gallery'); ?></label></th>
					<td><?php wp_dropdown_categories( $args ); ?></td>
				</tr>
				<tr>
					<th scope="row"><label for="rbs_post_create_title">Post Title</label></th>
					<td><input name="rbs_post_create_title" id="rbs_post_create_title" value="<?php echo $post_info->post_title ;?>" class="regular-text" type="text"></td>
				</tr>
			</tbody>
		</table>
		<?php
		
		echo '<p>'.__('Short tag of the gallery will be insert into created article.','rbs_gallery').'</p>';
	}
}