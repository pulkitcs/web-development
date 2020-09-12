import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types';

import CloseIcon from './components/CloseIcon';

import './PopupStyles.css';

let timeOut = 0;

const Popup = ({classes, body: Body, timer, delay, onClose}) => {
  const [isPopupOpen, togglePopupOpen] = useState(false); // Mange state to enable / disable popup
  const [isFirstTimeRender, toggleFirstTimeRender] = useState(false); // Mange state to check onPageLoad condition
  const handlePopupClose = () => {
    togglePopupOpen(false);
    onClose(); // Invoke the callback methods
  }

  useEffect(() => {
      if (!isPopupOpen && !isFirstTimeRender) {
        clearTimeout(timeOut)
        timeOut = setTimeout(() => {
          togglePopupOpen(true)
          toggleFirstTimeRender(true)
        }, delay)
      } else if (isPopupOpen && isFirstTimeRender) {
        clearTimeout(timeOut)
        timeOut = setTimeout(() => handlePopupClose(), timer)
      }
    });

  return (
    <>
      { isPopupOpen && (
        <section className={`popupContainer ${classes}`}>
          <article className="popupBox">
            <button onClick={() => {
              // Invoke the callback method
              togglePopupOpen(false);
              onClose();
              }}
              className="cancelButton"
            >
              <CloseIcon  />
            </button>
            <Body
              {...{
                handlePopupClose: handlePopupClose,
              }}
            />
          </article>
        </section>
      )}
    </>
  )
}

Popup.propTypes = {
  classes:  PropTypes.string,
  timer: PropTypes.number,
  delay: PropTypes.number,
  onClose: PropTypes.func,
}

Popup.defaultProps = {
  delay: 0,
  timer: 5000,
  classes: '',
  onClose: () => null,
}

export default Popup