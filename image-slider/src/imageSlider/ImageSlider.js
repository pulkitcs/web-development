import React, { useState, Fragment } from 'react';
import './ImageSliderStyles.css';

const ImageSlider = ({ imageArray = []}) => {
  const [currentIdx, updateIdx] = useState(0)

  const prev = (idx) => {
    let count = currentIdx;

    if (currentIdx > 0) {
      count--
    } else {
      count = imageArray.length - 1;
    }

    updateIdx(count)
  }

  const next = (idx) => {
    let count = currentIdx;
    
    if (currentIdx < (imageArray.length - 1)) {
      count++;
    }else {
      count = 0;
    }

    updateIdx(count);
  }

  const Preview = ({item}) => (
    <div className="container">
      <span onClick={() => prev(currentIdx)}>Prev</span>
      <div><img src={item} key={item} width="1100px" height="730px" alt={item} /></div>
      <span onClick={() => next(currentIdx)}>Next</span>
    </div>
  )
  
  const Gallery = ({items = []}) => (
    <div className="box">
      {
        items.map((item, idx) => (<div className="imageBox" key={item} onClick={() => updateIdx(idx)} >
          <img src={item} alt={item} className={currentIdx === idx ? "selected" : ''} height="150px" width="auto" />
        </div>))
      }
    </div>
  )

  return (
    <Fragment>
    <Preview 
      item={imageArray[currentIdx]}
    />
    <Gallery items={imageArray} />
    </Fragment>
  )
}

export default ImageSlider;
