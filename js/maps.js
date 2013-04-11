function map_init() {
	map = new OpenLayers.Map("basicMap");
	var mapnik	 = new OpenLayers.Layer.OSM();
	var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
	var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
	var position       = new OpenLayers.LonLat(15.00,63.18).transform( fromProjection, toProjection);
	var zoom	   = 5; 
 
	map.addLayer(mapnik);
	map.setCenter(position, zoom );
	OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
                defaultHandlerOptions: {
                    'single': true,
                    'double': false,
                    'pixelTolerance': 0,
                    'stopSingle': false,
                    'stopDouble': false
                },

                initialize: function(options) {
                    this.handlerOptions = OpenLayers.Util.extend(
                        {}, this.defaultHandlerOptions
                    );
                    OpenLayers.Control.prototype.initialize.apply(
                        this, arguments
                    );
                    this.handler = new OpenLayers.Handler.Click(
                        this, {
                            'click': this.trigger
                        }, this.handlerOptions
                    );
                },

                trigger: function(e) {
                    var lonlat = map.getLonLatFromPixel(e.xy);
  		    var lonlat1= new OpenLayers.LonLat(lonlat.lon,lonlat.lat).transform(toProjection,fromProjection);
                    var move_on = confirm("Search based on these coordinates: Lat: " + lonlat1.lat + " Long: " + lonlat1.lon );
		    if (move_on == true) {
                        window.location="/digikult/results.php?lat=" + lonlat1.lat + "&long=" + lonlat1.lon;
		    }
                }
	});
	var click = new OpenLayers.Control.Click();
        map.addControl(click);

        click.activate();
}
