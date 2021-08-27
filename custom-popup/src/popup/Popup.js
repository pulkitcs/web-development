import React, {
  Fragment,
  memo,
  useState,
  useEffect,
  useCallback,
  useRef,
} from "react";
import { createPortal } from "react-dom";
import PropTypes from "prop-types";

import CloseIcon from "./components/CloseIcon";

import "./PopupStyles.css";

const Popup = memo((props) => {
  const { children, classes, id, togglePopupOpen, onClose } = props;
  const [container] = useState(document.createElement("div"));

  useEffect(() => {
    container.setAttribute("data-id", id);
    document.body.appendChild(container);

    return () => {
      document.body.removeChild(container);
    };
  }, [container, id]);

  return createPortal(
    <Fragment>
      {
        <section className={`popupContainer ${classes}`}>
          <article className="popupBox">
            <button
              onClick={() => {
                // Invoke the callback method
                togglePopupOpen(false);
                onClose();
              }}
              className="cancelButton"
            >
              <CloseIcon />
            </button>
            {children}
          </article>
        </section>
      }
    </Fragment>,
    container
  );
});

const PopupController = ({
  classes,
  children,
  delay,
  forceClose,
  id = String(Math.random()),
  onClose,
  timer,
}) => {
  const [isPopupOpen, togglePopupOpen] = useState(false); // Manage state to enable / disable popup
  const [isFirstTimeRender, toggleFirstTimeRender] = useState(false); // Manage state to check onPageLoad condition
  const timeOut = useRef(0);

  const handlePopupClose = useCallback(() => {
    togglePopupOpen(false);
    onClose(); // Invoke the callback methods
  }, [togglePopupOpen, onClose]);

  forceClose(() => handlePopupClose());

  useEffect(() => {
    if (!isPopupOpen && !isFirstTimeRender) {
      clearTimeout(timeOut.current);
      timeOut.current = setTimeout(() => {
        togglePopupOpen(true);
        toggleFirstTimeRender(true);
      }, delay);
    } else if (isPopupOpen && isFirstTimeRender) {
      clearTimeout(timeOut.current);

      if (isFinite(timer) && typeof timer === "number") {
        timeOut.current = setTimeout(() => handlePopupClose(), timer);
      }
    }
  }, [isPopupOpen, isFirstTimeRender, handlePopupClose, delay, timer]);

  return (
    <>
      {isPopupOpen && (
        <Popup
          children={children}
          classes={classes}
          id={id}
          togglePopupOpen={togglePopupOpen}
          onClose={onClose}
        >
          {children}
        </Popup>
      )}
    </>
  );
};

PopupController.propTypes = {
  classes: PropTypes.string,
  delay: PropTypes.number,
  forceClose: PropTypes.func,
  id: PropTypes.string,
  onClose: PropTypes.func,
  timer: PropTypes.number,
};

PopupController.defaultProps = {
  classes: "",
  delay: 0,
  forceClose: () => null,
  onClose: () => null,
};

export default memo(PopupController);
