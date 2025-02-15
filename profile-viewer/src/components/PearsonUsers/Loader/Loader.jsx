import React, { Component } from 'react';
import PropType from "prop-types";

import styles from "./Loader.module.scss";
import AnimatedLoader from '../../../assets/images/loader.svg';

class Loader extends Component {
  render() {
    return (
      <React.Fragment>
        <img className={styles.loaderImg} height={this.props.height} width={this.props.width} src={AnimatedLoader} alt="loader" />
      </React.Fragment>
    )
  }
}

export default Loader;

Loader.propType = {
  height: PropType.number,
  width: PropType.number
};
