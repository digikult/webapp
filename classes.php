<?php


/* -------------------------------------------------------------------------------- */
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


/* -------------------------------------------------------------------------------- */
class europeiana extends objects {
    /** API-KEY */
    const EUROPEANA_API_KEY = "YkFCxJxoe";
    
    private function build_query($latMin, $latMax, $longMin, $longMax, $rows) {
        $searchString = "*:*";
        $start = 1;
        $profile = "standard";
        
        // Build the query
        $europeana_query = "http://europeana.eu/api//v2/search.json?wskey=" . europeiana::EUROPEANA_API_KEY;
        $europeana_query .= "&query=" . urlencode($searchString);
        $europeana_query .= "&qf=pl_wgs84_pos_lat" . urlencode(sprintf(":[%f TO %f]", $latMin, $latMax));
        $europeana_query .= "&qf=pl_wgs84_pos_long" . urlencode(sprintf(":[%f TO %f]", $longMin, $longMax));
        $europeana_query .= "&start=" . urlencode($start);
        $europeana_query .= "&rows=" . urlencode($rows);
        $europeana_query .= "&profile=" . urlencode($profile);

        return $europeana_query;
    }

    public function get_items() {
        // Query params
        $latMin = 0;
        $latMax = 0;
        $longMin = 0;
        $longMax = 0;
        $delta = 0.01;
        $rows = 96;
        $maxTries = 5;
        $i = 1;
        
        $lat = $this->coord["lat"];
        $long = $this->coord["long"];
        
        $itemsCount = 0;
        $totalResults = 0;
        while ($totalResults < $rows && $maxTries-- > 0) {
            try {
                // Make bounding box
                $latMin = $lat - $delta*$i;
                $latMax = $lat + $delta*$i;
                $longMin = $long - $delta*$i;
                $longMax = $long + $delta*$i;
        
                if (($file = file_get_contents($this->build_query($latMin, $latMax, $longMin, $longMax, $rows))) === FALSE) {
                    echo("error");
                    $this->items = array();
                    break;
                }
                $json = json_decode($file, true);
                
                // Set vars
                $itemsCount = $json["itemsCount"];
                $totalResults = $json["totalResults"];
                $success = $json["success"];
                if (!$success) {
                    $this->items = array();
                    break;
                }
                print_r($json);
                if ($itemsCount > 0)
                    $this->items = $json["items"];
                else
                    $this->items = array();
                
            } catch (Exception $error) {
                die($error);
            }
        }
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

/* -------------------------------------------------------------------------------- */
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

/* -------------------------------------------------------------------------------- */
class institutions extends objects {
	public function get_items() {}

	public function get_html() {}

}
