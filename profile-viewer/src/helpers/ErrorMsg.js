import React, { Component } from "react";
import PropTypes from 'prop-types';

import Close from '../assets/images/close.svg';

const boxStyle = {
  fontSize: "14px",
  color: "#fff",
  lineHeight: "18px",
  backgroundColor: "#ee3124",
  position: "fixed",
  top: 0,
  left: "50%",
  padding: "15px 10px 10px 10px",
  marginLeft: "-200px",
  width: "400px",
  minHeight: "50px",
  borderBottomLeftRadius: "5px",
  borderBottomRightRadius: "5px",
  opacity: .9,
  boxShadow: "0 0 10px 1px #ccc"
}

const coverStyle = {
  height: "100%",
  width: "100%",
  position: "fixed",
  backgroundColor: "rgba(255, 255, 255, .6)",
  top: 0,
  left: 0
}

const closeStyle = {
  position: "absolute",
  top: "5px",
  right: "5px",
  cursor: "pointer"
}

class ErrorMsg extends Component {
  render () {
    const { message, click } = this.props;
    return (
      <article style={coverStyle}>
        <p style={boxStyle} className="errormsg">
          <img src={Close} height="20px"  style={closeStyle} onClick={click} width="20px" alt="Click here to close" />
          {message}
        </p>
      </article>
    );
  }
}

export default ErrorMsg;

ErrorMsg.propTypes = {
  click: PropTypes.func,
  message: PropTypes.string
}