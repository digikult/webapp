<?php

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
    /** API-KEY */
    const EUROPEANA_API_KEY = "YkFCxJxoe";
    
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
	public function get_items() {
        // Query params
        $radius = 10000;// in meters
        $format = "json";
        $limit = 10; //500;// default 10, max 500
        
        
        // Build the query
        $wikipedia_query = "http://en.wikipedia.org/w/api.php";
        $wikipedia_query .= "?action=query";
        $wikipedia_query .= "&list=geosearch";
        $wikipedia_query .= "&gsradius=" . urlencode(sprintf("%d", $radius));
        $wikipedia_query .= "&gscoord=" . urlencode(sprintf("%f|%f", $this->coord["lat"], $this->coord["long"]));
        $wikipedia_query .= "&format=" . urlencode($format);
        $wikipedia_query .= "&gslimit=" . urlencode($limit);

        try {
            if (($file = file_get_contents($wikipedia_query)) === FALSE) {
                $this->items = array();
            }
            $json = json_decode($file, true);

            // Set vars
            $this->items = $json["query"]["geosearch"];
            /*                    [0] => Array
                                    (
                                        [pageid] => 4299833
                                        [ns] => 0
                                        [title] => City Museum of Gothenburg
                                        [lat] => 57.7064
                                        [lon] => 11.9633
                                        [dist] => 172.1
                                        [primary] => 
                                    )
            */
        } catch (Exception $error) {
            die($error);
        }
	}

    public function get_html() {
        $html = "<ul>";

        foreach ($this->items as $item) {
            $html .= sprintf('<li class="wikipedia"><a href="%s">%s</a></li>', "http://en.wikipedia.org/wiki?curid={$item["pageid"]}", $item["title"]);
        }
        
        $html .= "</ul>";
        echo($html);
    }
}

class institutions extends objects {
	public function get_items() {}

	public function get_html() {}

}
