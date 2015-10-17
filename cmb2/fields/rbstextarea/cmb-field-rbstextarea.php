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


function jt_cmb2_rbstextarea_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_rbstextarea_field( $metakey, $post_id );
}

function jt_cmb2_render_rbstextarea_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	$value =  $value ? $value : $field->args('default') ;

?>
<div class="form-horizontal">
	<div class="form-group">
		<div class="col-sm-2">
	    	<label class=" control-label" for="<?php echo $field_type_object->_id(); ?>"><?php echo esc_html(  $field->args('name') ); ?></label>
	   		<?php echo $field_type_object->_desc( true );  ?>
	    </div>
	    <div class="<?php echo $field->args('small')?'col-sm-4':'col-sm-10'; ?>">
	    	<?php
	    		echo '<textarea '
	    				.'id="'.$field_type_object->_id().'" '
	    				.'name="'.$field_type_object->_name().'" '
	    				.'class="form-control '.$field_type_object->args('class').'" '
	    				.'rows="6"> '
	    				.$value
	    		.'</textarea>';
			?> 
	    </div>
	</div>
</div>
<?php
}
add_filter( 'cmb2_render_rbstextarea', 'jt_cmb2_render_rbstextarea_field_callback', 10, 5 );