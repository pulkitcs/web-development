import React, { Component } from 'react';
import PropType from "prop-types";
import AnimatedLoader from '../assets/images/loader.svg';

const style = {
  position: "absolute",
  left: "50%",
  top: "50%"
};

class Loader extends Component {
  render() {
    return (
      <React.Fragment>
        <img style={style} height={this.props.height} width={this.props.width} src={AnimatedLoader} alt="loader" />
      </React.Fragment>
    )
  }
}

export default Loader;

Loader.propType = {
  height: PropType.number,
  width: PropType.number
};
