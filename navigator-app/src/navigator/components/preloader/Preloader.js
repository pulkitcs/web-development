import React, { PureComponent } from 'react';
import './Preloader.css';
import PropTypes from 'prop-types';

class Preloader extends PureComponent {
  render() {
    const { enable } = this.props;
    return (
      enable && (
        <div className="preloader">
          <div className="preloader4"></div>
        </div>
      )
    )
  }
}

export default Preloader;

Preloader.propTypes = {
  enable: PropTypes.bool.isRequired
};
