<?php

// Definitions
DEFINE("EUROPEANA_API_KEY", "YkFCxJxoe");

class objects {
    $coord = array( "lat" => 0.0, "long" => 0.0, "city" => null );

    /** Construct the class given the coordinates */
    public function __construct($coord) {
        // Initialize the given coord
        $this->coord = $coord;
        
        // Fetch the data from web service
        this->get_items();
    }

    /** Fetch the items from Web Service */
	public function get_items() {}

    /** Print the HTML directly */
	public function get_html() {}
}


class europeiana extends objects {
    $items = 0;
    $itemsPerQuery = 0;
    $totalItems = 0;
    
    
    public function get_items() {
        // Make the ws call
        // Parse JSON
    }
    
    public function get_html() {
        $html = "<ul>";

        foreach ($items as $item) {
            $html .= sprintf('<li>%s</li>', $item);
        }
        
        $html .= "</ul>";
        echo($html);
    }
}

class wikipedia extends objects {
	public function get_items() {}

    public function get_html() {
        $html = "<ul>";

        foreach ($items as $item) {
            $html .= sprintf('<li>%s</li>', $item);
        }
        
        $html .= "</ul>";
        echo($html);
    }
}

class institutions extends objects {
	public function get_items() {}

	public function get_html() {}

}
