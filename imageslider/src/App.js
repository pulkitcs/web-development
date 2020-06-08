import React from 'react';
import logo from './logo.svg';
import './App.css';
import ImageSlider from './imageSlider/ImageSlider';
import img2 from './imageSlider/assets/images/1-1.jpg'
import img3 from './imageSlider/assets/images/1-2.jpg'
import img4 from './imageSlider/assets/images/1-3.jpg'
import img5 from './imageSlider/assets/images/1-4.jpg'

const imageArray = [
  img2,img3,img4,img5,
];

function App() {
  return (
    <div className="App">
    <ImageSlider imageArray={imageArray} />
    </div>
  );
}

export default App;
