<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/icons/html.png" height="30" title="HTML5">&nbsp;<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/icons/css.png" title="CSS" height="30">&nbsp;<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/icons/js.png" height="30" title="JAVASCRIPT">&nbsp;<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/icons/node.png" height="35" title="NODE.JS">&nbsp;<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/icons/react.png" height="30" title="REACT.JS">

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).
# Navigator App

Application to plot distance between two locations on Google Map

## Pre-Requisties

Backend [mockApi](https://github.com/lalamove/challenge/tree/master/mockApi) should be running on the system

## Google Maps Api configuration

Create a `.env` file in the root directory of the project and add the following line and update the `Google` Api key

```
REACT_APP_GMAP_KEY = <Google Api key>
```

Google map configurations are stored in `/src/navigator/config/gmap.js` with the default configuration as:

```
{
  "MAP_SETTINGS" : {
    "center": {
      "lat": -34.397,
      "lng": 150.644
    },
    "zoom": 8
  },
  "TRAVEL_MODE": "DRIVING",
  "LIBRARIES": ["geometry", "places"],
  "LANGUAGE": "en"
}
```

## Steps to run app

```
npm install
npm start
```

## Tests

Run `npm test` to run the tests


<img src="https://raw.githubusercontent.com/wiki/pulkitcs/web-development/screenshots/Navigator/Navigator.png" alt= "Navigator App screenshot"/>