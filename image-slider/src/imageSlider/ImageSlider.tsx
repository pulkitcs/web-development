import { useState, Fragment } from 'react';
import './ImageSliderStyles.css';

const Preview = ({ item, next, prev }: { item: string; next: () => void; prev: () => void }) => (
  <div className="container">
    <span onClick={() => prev()}>Prev</span>
    <div><img src={item} key={item} width="1100px" height="730px" alt={item} /></div>
    <span onClick={() => next()}>Next</span>
  </div>
)

const Gallery = ({ items = [], currentIdx, updateIdx }: { items: string[]; currentIdx: number; updateIdx: (arg: number) => void }) => (
  <div className="box">
    {
      items.map((item: string, idx: number) => (<div className="imageBox" key={item} onClick={() => updateIdx(idx)} >
        <img src={item} alt={item} className={currentIdx === idx ? "selected" : ''} height="150px" width="auto" />
      </div>))
    }
  </div>
)


const ImageSlider = ({ imageArray = [] }: { imageArray: string[] }): React.ReactNode => {
  const [currentIdx, updateIdx] = useState<number>(0)

  const prev = (): void => {
    let count = currentIdx;

    if (currentIdx > 0) {
      count--
    } else {
      count = imageArray.length - 1;
    }

    updateIdx(count)
  }

  const next = (): void => {
    let count = currentIdx;

    if (currentIdx < (imageArray.length - 1)) {
      count++;
    } else {
      count = 0;
    }

    updateIdx(count);
  }

  return (
    <Fragment>
      <Preview
        item={imageArray[currentIdx]}
        next={next}
        prev={prev}
      />
      <Gallery items={imageArray} currentIdx={currentIdx} updateIdx={updateIdx} />
    </Fragment>
  )
}

export default ImageSlider;
