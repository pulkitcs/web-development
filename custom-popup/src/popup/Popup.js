import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types';

import CloseIcon from './components/CloseIcon';

import './PopupStyles.css';

let timeOut = 0;

const Popup = ({classes, children, delay, forceClose, onClose, timer }) => {
  const [isPopupOpen, togglePopupOpen] = useState(false); // Mange state to enable / disable popup
  const [isFirstTimeRender, toggleFirstTimeRender] = useState(false); // Mange state to check onPageLoad condition
  const handlePopupClose = () => {
    togglePopupOpen(false);
    onClose(); // Invoke the callback methods
  }

  forceClose(() => handlePopupClose());

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
            { children }
          </article>
        </section>
      )}
    </>
  )
}

Popup.propTypes = {
  classes:  PropTypes.string,
  delay: PropTypes.number,
  forceClose: PropTypes.func,
  onClose: PropTypes.func,
  timer: PropTypes.number,
}

Popup.defaultProps = {
  classes: '',
  delay: 0,
  forceClose: () => null,
  onClose: () => null,
  timer: 5000,
}

export default Popup