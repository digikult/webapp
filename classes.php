<?php

// Definitions
DEFINE("EUROPEANA_API_KEY", "YkFCxJxoe");

abstract class objects {
    protected $coord;// = array( "lat" => 0.0, "long" => 0.0, "city" => null );
    protected $items;

    /** Construct the class given the coordinates */
    public function __construct($coord) {
        // Initialize the given coord
        $this->coord = $coord;
        
        // Fetch the data from web service
        $this->get_items();
    }

    /** Fetch the items from Web Service */
	abstract public function get_items();

    /** Print the HTML directly */
	abstract public function get_html();
}


class europeiana extends objects {
    
    public function get_items() {
        $itemsPerQuery = 0;
        $totalItems = 0;
    
        // Make the ws call
        // Parse JSON
        $this->items = array(1337);
    }
    
    public function get_html() {
        $html = "<ul>";

        foreach ($this->items as $item) {
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

        foreach ($this->items as $item) {
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
