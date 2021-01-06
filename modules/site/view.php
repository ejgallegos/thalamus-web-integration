<?php


class SiteView extends View {
	function home($error = null) {
		$gui_contenido = file_get_contents("static/modules/site/home.html");
		if ($error) {
			$error = $this->set_dict_stdclass($error);
			$gui_contenido = $this->render($error, $gui_contenido);
		}
		$display = array('display' => 'none', );
		$display = $this->set_dict_stdclass($display);
		$gui_contenido = $this->render($display, $gui_contenido);
		$template = $this->render_site("THEME_HOME", $gui_contenido);
		print $template;
	}
	
	function person($person) {
		$gui_contenido = file_get_contents("static/modules/site/person.html");
		$person = $this->set_dict_stdclass($person);
		$render = $this->render($person, $gui_contenido);
		$template = $this->render_site("THEME_HOME", $render);
		print $template;
	}
	
	function updateFormPerson() {
		$gui_contenido = file_get_contents("static/modules/site/update-person.html");
		$template = $this->render_site("THEME_HOME", $gui_contenido);
		print $template;
	}
	
}
