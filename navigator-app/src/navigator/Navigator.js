import React, { Component } from 'react';
import SearchForm from './components/searchForm';
import { gmap } from  './services/maps';
import GMAP_SETTINGS from './config/gmap';
import "./Navigator.css";

class Navigator extends Component {
  
  constructor() {
    super();

    this.directionsDisplay = {};
    this.directionService = {};
    this.gmaps = {};
    this.newmap = {};
    this.mapContainer = React.createRef();
    this.mapConfig = Object.create(GMAP_SETTINGS);
  }

  componentDidMount() {
    this.initializeMap();
  }

  // Method to initialize the Google Maps
  initializeMap = async () => {
    const { gmap } = this.props
    this.gmaps = await gmap();
    this.newmap = new this.gmaps.Map(this.mapContainer.current, this.mapConfig.MAP_SETTINGS);
  }

  // Method to destroy direction service data and clear generated route
  clearMapDirection = () => {
    if (this.directionsDisplay.set)
      this.directionsDisplay.set('directions', null);
    else 
      return;
  }

  // Method to plot the Route on the Map
	mapCoordinates = (path) => {
    const origin = path[0];
    const distination = path[path.length -1];
    this.directionService = new this.gmaps.DirectionsService();
    this.directionsDisplay = new this.gmaps.DirectionsRenderer();
    this.directionsDisplay.setMap(this.newmap);

		this.directionService.route({
			origin: new this.gmaps.LatLng(origin[0], origin[1]),
			destination: new this.gmaps.LatLng(distination[0], distination[1]),
			travelMode: this.mapConfig.TRAVEL_MODE
		},  (response, status) => {
          if (status === 'OK') {
            this.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
		    });
  }
  
  render() {
    return (
      <div className='box'>
        <section id='controls'>
          <SearchForm 
            clearMapDirection = {this.clearMapDirection}
            mapCoordinates = {this.mapCoordinates}
          />
        </section>
        <div id='map' ref={this.mapContainer}></div>
      </div>
    );
  }
}

export default Navigator;

Navigator.defaultProps = {
  gmap
};