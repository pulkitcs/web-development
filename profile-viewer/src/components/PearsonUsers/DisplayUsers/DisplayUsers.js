import React, { Component } from "react";
import PropTypes from "prop-types";

import styles from "./DisplayUsers.module.scss";
class DisplayUsers extends Component {

  // Method to generate tiles based on API data
  createUserTiles = (data) => data.map((item, key) => (
    <div id={item.id} className={styles.tile} key={key}>
      <h1 className={styles.name}>{`${item.first_name} ${item.last_name}`}</h1>
      <img alt={`${item.first_name} ${item.last_name} Profile Pic`} height="80px" width="80px" className={styles.tileImg} src={item.avatar} />
      <p className={styles.delete} onClick={()=>{this.props.onclick(key)}}>Delete</p>
    </div>
  )); 

  render () {
    const { data } = this.props;
    return (
      <React.Fragment>
        { this.createUserTiles(data) }
      </React.Fragment>
    )
  }
}

export default DisplayUsers;

DisplayUsers.propTypes = {
  data: PropTypes.array,
  onclick: PropTypes.func
}