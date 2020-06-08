import GoogleMapsLoader from 'google-maps';
import GMAP_SETTINGS from '../../config/gmap';

let gMap;
let settings = Object.create(GMAP_SETTINGS); // Specified in the gmap config file

// Method to apply Google Maps API key
const setApiKeyVariable = () => {
  const key = process.env.REACT_APP_GMAP_KEY;

  if (key) {
    GoogleMapsLoader.KEY = key;
  } else {
    alert('Google Maps API key is not defined, please refer the project README file for more information')
  }
}

// Method to specify GoogleMapsLoader settings
const setVariables = (config) => {
  GoogleMapsLoader.LANGUAGE = config.LANGUAGE;
  GoogleMapsLoader.LIBRARIES = config.LIBRARIES;
  GoogleMapsLoader.VERSION = '3.35';
  setApiKeyVariable();
}

setVariables(settings);

// Method to load GoogleMapsLoader library
const loadMap = () => {
  return new Promise((resolve, reject) => {
    GoogleMapsLoader.load((google) => {
      resolve(google.maps);
    });
  });
}

// Method to check and return existing instance of Google Maps library
export const gmap = async () => {
  if (typeof gMap !== "undefined") {
    return gMap;
  } else { 
    gMap = await loadMap();
    return gMap;
  }
}