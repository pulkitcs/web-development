import React, { Component } from "react";
import PropTypes from 'prop-types';
import styles from './ErrorMsg.module.scss'
import Close from '../../../assets/images/close.svg';

class ErrorMsg extends Component {
  render () {
    const { message, click } = this.props;
    return (
      <article className={styles.coverStyle}>
        <p className={styles.boxStyle}>
          <img src={Close} height="20px"  className={styles.closeStyle} onClick={click} width="20px" alt="Click here to close" />
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