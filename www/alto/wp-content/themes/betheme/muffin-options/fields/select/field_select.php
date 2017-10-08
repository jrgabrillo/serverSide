<?php
class MFN_Options_select extends MFN_Options{	
	
	/**
	 * Constructor
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){

		if( is_object($parent) ){
			parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		}
		
		$this->field = $field;
		$this->value = $value;
		
	}
	
	/**
	 * Render
	 */
	function render( $meta = false ){
		
		// class -----------------------------------------------------	
		if( isset( $this->field['class']) ){
			$class = $this->field['class'];
		} else {
			$class = '';
		}
		
		// name -----------------------------------------------------		
		if( $meta == 'new' ){
				
			// builder
			$name = 'data-name="'. $this->field['id'] .'"';
				
		} elseif( $meta ){
				
			// page mata & builder existing items
			$name = 'name="'. $this->field['id'] .'"';
				
		} else {
				
			// theme options
			$name = 'name="'. $this->args['opt_name'] .'['. $this->field['id'] .']"';
		
		}
		
		// echo -----------------------------------------------------	
		echo '<select '. $name .' class="'.$class.'" rows="6" >';
			if( is_array( $this->field['options'] ) ){
				foreach( $this->field['options'] as $k => $v ){
					echo '<option value="'.$k.'" '. selected($this->value, $k, false) .'>'. $v .'</option>';
				}
			}
		echo '</select>';

		if( isset($this->field['desc']) && !empty($this->field['desc']) ){
			echo '<span class="description '.$class.'">'. $this->field['desc'] .'</span>';	
		}
		
	}
	
}
?>