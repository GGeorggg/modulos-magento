<?php
 
class Uni_Banner_Block_Adminhtml_Effects_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
	protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getEffectsData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getEffectsData();
            Mage::getSingleton('adminhtml/session')->getEffectsData(null);
        }
        elseif (Mage::registry('effects_data'))
        {
            $data = Mage::registry('effects_data')->getData();
        }
        else
        {
            $data = array();
			echo "<script>alert('else')</script>";
        }
 
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
        ));
 
        $form->setUseContainer(true);
 
        $this->setForm($form);
 
        $fieldset = $form->addFieldset('effects_form', array(
             'legend' =>Mage::helper('banner')->__('Create Effect')
        ));
 
        $fieldset->addField('effect_name', 'text', array(
             'label'     => Mage::helper('banner')->__('Effect Name'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'effect_name',
        ));
		
		$fieldset->addField('animation', 'select', array(
             'label'    => Mage::helper('banner')->__('Animation'),
             'name'     => 'animation',
			 'values'	=> array(
				array(
                    'value' => '',
                    'label' => Mage::helper('banner')->__('No effect'),
                ),
                array(
                    'value' => 'cube',
                    'label' => Mage::helper('banner')->__('cube'),
                ),
                array(
                    'value' => 'cubeRandom',
                    'label' => Mage::helper('banner')->__('cubeRandom'),
                ),
				array(
                    'value' => 'block',
                    'label' => Mage::helper('banner')->__('block'),
                ),
				array(
                    'value' => 'cubeStop',
                    'label' => Mage::helper('banner')->__('cubeStop'),
                ),
				array(
                    'value' => 'cubeHide',
                    'label' => Mage::helper('banner')->__('cubeHide'),
                ),
				array(
                    'value' => 'cubeSize',
                    'label' => Mage::helper('banner')->__('cubeSize'),
                ),
				array(
                    'value' => 'horizontal',
                    'label' => Mage::helper('banner')->__('horizontal'),
                ),
				array(
                    'value' => 'showBars',
                    'label' => Mage::helper('banner')->__('showBars'),
                ),
				array(
                    'value' => 'showBarsRandom',
                    'label' => Mage::helper('banner')->__('showBarsRandom'),
                ),
				array(
                    'value' => 'tube',
                    'label' => Mage::helper('banner')->__('tube'),
                ),
				array(
                    'value' => 'fade',
                    'label' => Mage::helper('banner')->__('fade'),
                ),
				array(
                    'value' => 'fadeFour',
                    'label' => Mage::helper('banner')->__('fadeFour'),
                ),
				array(
                    'value' => 'paralell',
                    'label' => Mage::helper('banner')->__('paralell'),
                ),
				array(
                    'value' => 'blind',
                    'label' => Mage::helper('banner')->__('blind'),
                ),
				array(
                    'value' => 'blind',
                    'label' => Mage::helper('banner')->__('blind'),
                ),
				array(
                    'value' => 'blindHeight',
                    'label' => Mage::helper('banner')->__('blindHeight'),
                ),
				array(
                    'value' => 'blindWidth',
                    'label' => Mage::helper('banner')->__('blindWidth'),
                ),
				array(
                    'value' => 'directionTop',
                    'label' => Mage::helper('banner')->__('directionTop'),
                ),
				array(
                    'value' => 'directionBottom',
                    'label' => Mage::helper('banner')->__('directionBottom'),
                ),
				array(
                    'value' => 'directionRight',
                    'label' => Mage::helper('banner')->__('directionRight'),
                ),
				array(
                    'value' => 'directionLeft',
                    'label' => Mage::helper('banner')->__('directionLeft'),
                ),
				array(
                    'value' => 'cubeStopRandom',
                    'label' => Mage::helper('banner')->__('cubeStopRandom'),
                ),
				array(
                    'value' => 'cubeSpread',
                    'label' => Mage::helper('banner')->__('cubeSpread'),
                ),
				array(
                    'value' => 'cubeJelly',
                    'label' => Mage::helper('banner')->__('cubeJelly'),
                ),
				array(
                    'value' => 'glassCube',
                    'label' => Mage::helper('banner')->__('glassCube'),
                ),
				array(
                    'value' => 'glassBlock',
                    'label' => Mage::helper('banner')->__('glassBlock'),
                ),
				array(
                    'value' => 'circlesInside',
                    'label' => Mage::helper('banner')->__('circlesInside'),
                ),
				array(
                    'value' => 'circlesRotate',
                    'label' => Mage::helper('banner')->__('circlesRotate'),
                ),
				array(
                    'value' => 'cubeShow',
                    'label' => Mage::helper('banner')->__('cubeShow'),
                ),
				array(
                    'value' => 'upBars',
                    'label' => Mage::helper('banner')->__('upBars'),
                ),
				array(
                    'value' => 'downBars',
                    'label' => Mage::helper('banner')->__('downBars'),
                ),
				array(
                    'value' => 'hideBars',
                    'label' => Mage::helper('banner')->__('hideBars'),
                ),
				array(
                    'value' => 'swapBars',
                    'label' => Mage::helper('banner')->__('swapBars'),
                ),
				array(
                    'value' => 'swapBarsBack',
                    'label' => Mage::helper('banner')->__('swapBarsBack'),
                ),
				array(
                    'value' => 'swapBlocks',
                    'label' => Mage::helper('banner')->__('swapBlocks'),
                ),
				array(
                    'value' => 'cut',
                    'label' => Mage::helper('banner')->__('cut'),
                ),
				array(
                    'value' => 'random',
                    'label' => Mage::helper('banner')->__('random'),
                ),
				array(
                    'value' => 'randomSmart',
                    'label' => Mage::helper('banner')->__('randomSmart'),
                ),
				
            ),
			
        ));
		
		$fieldset->addField('auto_play', 'select', array(
            'label' => Mage::helper('banner')->__('Auto Play'),
            'class' => 'required-entry',
            'name' => 'auto_play',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('controls', 'select', array(
            'label' => Mage::helper('banner')->__('Controls'),
            'class' => 'required-entry',
            'name' => 'controls',
            'values' => array(
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
            ),
        ));
		
		$fieldset->addField('controls_position', 'select', array(
            'label' => Mage::helper('banner')->__('Controls Position'),
            'class' => 'required-entry',
            'name' => 'controls_position',
            'values' => array(
                array(
                    'value' => 'center',
                    'label' => Mage::helper('banner')->__('Center'),
                ),
                array(
                    'value' => 'leftTop',
                    'label' => Mage::helper('banner')->__('Left Top'),
                ),
				array(
                    'value' => 'rightTop',
                    'label' => Mage::helper('banner')->__('Right Top'),
                ),
				array(
                    'value' => 'leftBottom',
                    'label' => Mage::helper('banner')->__('Left Bottom'),
                ),
				array(
                    'value' => 'rightBottom',
                    'label' => Mage::helper('banner')->__('Right Bottom'),
                ),
			
            ),
        ));
		
		$fieldset->addField('dots', 'select', array(
            'label' => Mage::helper('banner')->__('Dots'),
            'class' => 'required-entry',
            'name' => 'dots',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('enable_navigation_keys', 'select', array(
            'label' => Mage::helper('banner')->__('Enable Navigation Keys'),
            'class' => 'required-entry',
            'name' => 'enable_navigation_keys',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('focus', 'select', array(
            'label' => Mage::helper('banner')->__('Focus'),
            'class' => 'required-entry',
            'name' => 'focus',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('focus_position', 'select', array(
            'label' => Mage::helper('banner')->__('Focus Position'),
            'class' => 'required-entry',
            'name' => 'focus_position',
            'values' => array(
                array(
                    'value' => 'center',
                    'label' => Mage::helper('banner')->__('Center'),
                ),
                array(
                    'value' => 'leftTop',
                    'label' => Mage::helper('banner')->__('Left Top'),
                ),
				array(
                    'value' => 'rightTop',
                    'label' => Mage::helper('banner')->__('Right Top'),
                ),
				array(
                    'value' => 'leftBottom',
                    'label' => Mage::helper('banner')->__('Left Bottom'),
                ),
				array(
                    'value' => 'rightBottom',
                    'label' => Mage::helper('banner')->__('Right Bottom'),
                ),
            ),
        ));
				
		$fieldset->addField('fullscreen', 'select', array(
            'label' => Mage::helper('banner')->__('Fullscreen'),
            'class' => 'required-entry',
            'name' => 'fullscreen',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('hide_tools', 'select', array(
            'label' => Mage::helper('banner')->__('Hide Tools'),
            'class' => 'required-entry',
            'name' => 'hide_tools',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('label', 'select', array(
            'label' => Mage::helper('banner')->__('Label '),
            'class' => 'required-entry',
            'name' => 'label',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('label_animation', 'select', array(
            'label' => Mage::helper('banner')->__('Label Animation'),
            'class' => 'required-entry',
            'name' => 'label_animation',
            'values' => array(
                array(
                    'value' => 'slideUp',
                    'label' => Mage::helper('banner')->__('Slide Up'),
                ),
                array(
                    'value' => 'left',
                    'label' => Mage::helper('banner')->__('Left'),
                ),
				array(
                    'value' => 'right',
                    'label' => Mage::helper('banner')->__('Right'),
                ),
				array(
                    'value' => 'fixed',
                    'label' => Mage::helper('banner')->__('Fixed'),
                ),		
            ),
        ));
		
		$fieldset->addField('navigation', 'select', array(
            'label' => Mage::helper('banner')->__('Navigation'),
            'class' => 'required-entry',
            'name' => 'navigation',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('numbers', 'select', array(
            'label' => Mage::helper('banner')->__('Numbers'),
            'class' => 'required-entry',
            'name' => 'numbers',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('numbers_align', 'select', array(
            'label' => Mage::helper('banner')->__('Numbers Align'),
            'class' => 'required-entry',
            'name' => 'numbers_align',
            'values' => array(
                array(
                    'value' => 'center',
                    'label' => Mage::helper('banner')->__('Center'),
                ),
                array(
                    'value' => 'left',
                    'label' => Mage::helper('banner')->__('Left'),
                ),
				array(
                    'value' => 'right',
                    'label' => Mage::helper('banner')->__('Right'),
                ),		
            ),
        ));
		
		$fieldset->addField('preview', 'select', array(
            'label' => Mage::helper('banner')->__('Preview'),
            'class' => 'required-entry',
            'name' => 'preview',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('progressbar', 'select', array(
            'label' => Mage::helper('banner')->__('Progressbar'),
            'class' => 'required-entry',
            'name' => 'progressbar',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('show_randomly', 'select', array(
            'label' => Mage::helper('banner')->__('Show Randomly'),
            'class' => 'required-entry',
            'name' => 'show_randomly',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('stop_over', 'select', array(
            'label' => Mage::helper('banner')->__('Stop Over'),
            'class' => 'required-entry',
            'name' => 'stop_over',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('theme', 'select', array(
            'label' => Mage::helper('banner')->__('Theme'),
            'class' => 'required-entry',
            'name' => 'theme',
            'values' => array(
                array(
                    'value' => 'minimalist',
                    'label' => Mage::helper('banner')->__('Minimalist'),
                ),
                array(
                    'value' => 'round',
                    'label' => Mage::helper('banner')->__('Round'),
                ),
				array(
                    'value' => 'clean',
                    'label' => Mage::helper('banner')->__('Clean'),
                ),
				array(
                    'value' => 'square',
                    'label' => Mage::helper('banner')->__('Square'),
                ),		
            ),
        ));
		
		$fieldset->addField('thumbs', 'select', array(
            'label' => Mage::helper('banner')->__('Thumbs'),
            'class' => 'required-entry',
            'name' => 'thumbs',
            'values' => array(
                array(
                    'value' => 'false',
                    'label' => Mage::helper('banner')->__('No'),
                ),
                array(
                    'value' => 'true',
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
            ),
        ));
		
		$fieldset->addField('with_animations', 'select', array(
            'label' => Mage::helper('banner')->__('With Animations'),
            'class' => 'required-entry',
            'name' => 'with_animations',
            'values' => array(
                array(
                    'value' => 'paralell',
                    'label' => Mage::helper('banner')->__('paralell'),
                ),
                array(
                    'value' => 'glassCube',
                    'label' => Mage::helper('banner')->__('Glass Cube'),
                ),
				array(
                    'value' => 'swapBars',
                    'label' => Mage::helper('banner')->__('Swap Bars'),
                ),
            ),
        ));

		$fieldset->addField('easing_default', 'text', array(
			'name' 		=> 'easing_default',
            'label' 	=> Mage::helper('banner')->__('Easing Default'),                
            'required' 	=> false,
			'note'		=> "For example 'easeOutBack'",
        ));
		
		$fieldset->addField('interval', 'text', array(
			'name' 		=> 'interval',
            'label' 	=> Mage::helper('banner')->__('Interval'),                
            'required' 	=> false,
			'note'		=> "For example 3000",
        ));
		
		$fieldset->addField('velocity', 'text', array(
			'name' 		=> 'velocity',
            'label' 	=> Mage::helper('banner')->__('Velocity'),                
            'required' 	=> false,
			'note'		=> "For example 0.5 ",
        ));
		
		$fieldset->addField('width_label', 'text', array(
			'name' 		=> 'width_label',
            'label' 	=> Mage::helper('banner')->__('width_label'),                
            'required' 	=> false,
			'note'		=> "300px",
        ));
		
		$fieldset->addField('animate_number_active', 'editor', array(
			'name' 		=> 'animate_number_active',
            'label' 	=> Mage::helper('banner')->__('Animate Number Active'),
            'title' 	=> Mage::helper('banner')->__('Animate Number Active'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example backgroundColor:'#000', color:'#ccc'",
        ));
		
		$fieldset->addField('animate_number_out', 'editor', array(
			'name' 		=> 'animate_number_out',
            'label' 	=> Mage::helper('banner')->__('Animate Number Out'),
            'title' 	=> Mage::helper('banner')->__('Animate Number Out'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example backgroundColor:'#000', color:'#ccc'",
        ));
		
		$fieldset->addField('animate_number_over', 'editor', array(
			'name' 		=> 'animate_number_over',
            'label' 	=> Mage::helper('banner')->__('Animate Number Over'),
            'title' 	=> Mage::helper('banner')->__('Animate Number Over'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example backgroundColor:'#000', color:'#ccc'",
        ));
		
		$fieldset->addField('image_switched', 'editor', array(
			'name' 		=> 'image_switched',
            'label' 	=> Mage::helper('banner')->__('Image Switched'),
            'title' 	=> Mage::helper('banner')->__('Image Switched'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example funtion( image_i, self ) { console.log( image_i); }",
        ));
		
		$fieldset->addField('mouse_out_button', 'editor', array(
			'name' 		=> 'mouse_out_button',
            'label' 	=> Mage::helper('banner')->__('Mouse Out Button'),
            'title' 	=> Mage::helper('banner')->__('Mouse Out Button'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example function() { $(this).stop().animate({opacity:0.2}, 500);",
        ));
		
		$fieldset->addField('mouse_over_button', 'editor', array(
			'name' 		=> 'mouse_over_button',
            'label' 	=> Mage::helper('banner')->__('Mouse Over Button'),
            'title' 	=> Mage::helper('banner')->__('Mouse Over Button'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example function() { $(this).stop().animate({opacity:0.2}, 500);",
        ));
		
		$fieldset->addField('on_load', 'editor', array(
			'name' 		=> 'on_load',
            'label' 	=> Mage::helper('banner')->__('On Load'),
            'title' 	=> Mage::helper('banner')->__('On Load'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example function(self) { console.log(self.settings.animation); }",
        ));
		
		$fieldset->addField('progressbar_css', 'editor', array(
			'name' 		=> 'progressbar_css',
            'label' 	=> Mage::helper('banner')->__('Progressbar Css'),
            'title' 	=> Mage::helper('banner')->__('Progressbar Css'),
            'style' 	=> 'width:274px; height:100px;',                
            'wysiwyg' 	=> false,
            'required' 	=> false,
			'note'		=> "For example backgroundColor: '#000'",
        ));
	
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
	
}