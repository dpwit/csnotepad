<?
	class TestimonialHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this,false,10);
			cms_register_filter('cms_menu',$this,false,10);
		}
		
		function models_loaded(){
			Model::addModel('Testimonial',dirname(__FILE__).'/class.TestimonialModel.php','TestimonialModel');
		}
		
		function cms_menu($menu){
			$menu['Testimonials']['View All Testimonials'] = "overview.php?model=TestimonialModel&section=Testimonial";
			$menu['Testimonials']['New Testimonial'] = "newItem.php?model=TestimonialModel&section=Testimonial";
			return $menu;
		}
	}
	new TestimonialHooks;