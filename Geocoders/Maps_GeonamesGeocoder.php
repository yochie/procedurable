<?php

/**
 * MODIFICATION YOANN: Destination = /wiki.fablabsnation.ca/public_html/core/extensions/Maps/includes/geocoders
 * Class for geocoding requests with the GeoNames webservice.
 * 
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsGeonamesGeocoder extends \Maps\Geocoder {
	
	/**
	 * Registers the geocoder.
	 * 
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 * 
	 * @since 1.0
	 */
	public static function register() {
		global $egMapsGeoNamesUser;
		
		if ( $egMapsGeoNamesUser !== '' ) {
			\Maps\Geocoders::registerGeocoder( 'geonames', __CLASS__ );
		}
		
		return true;
	}	
	
	/**
	 * @see \Maps\Geocoder::getRequestUrl
	 * 
	 * @since 1.0
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */	
	protected function getRequestUrl( $address ) {
		global $egMapsGeoNamesUser;
		
		//MODIFICATION YOANN
		return 'https://geocoder.ca/?locate=' . urlencode( $address ) . '&geoit=csv';

		//ORIGINALE
		//return 'http://api.geonames.org/search?q=' . urlencode( $address ) . '&maxRows=1&username=' . urlencode( $egMapsGeoNamesUser );
	}
	
	/**
	 * @see \Maps\Geocoder::parseResponse
	 * 
	 * @since 1.0
	 * 
	 * @param string $response
	 * 
	 * @return array
	 */		
	protected function parseResponse( $response ) {
	//MODIFICATION YOANN
		$csvValues = explode (',',$response,4);
		$lat = floatval($csvValues[2]);
		$lon = floatval($csvValues[3]);
	
	//ORIGINALE
	//	$lon = self::getXmlElementValue( $response, 'lng' );
	//	$lat = self::getXmlElementValue( $response, 'lat' );

		// In case one of the values is not found, return false.
		if ( !$lon || !$lat ) return false;

		return [
			'lat' => (float)$lat,
			'lon' => (float)$lon
		];		
	}
	
}