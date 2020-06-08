import React, { Component } from "react";
import DisplayUsers from './DisplayUsers';

import SampleData from './data.json';
import ApiFetch from '../../helpers/ApiFetch.js';
import Loader from '../../helpers/Loader.js';
import ErrorMsg from '../../helpers/ErrorMsg';

import PATHS from '../../configs/path.config.json';
import CONSTANTS from '../../configs/constants.json';

import './style.css';

class PearsonUsers extends Component {
  constructor() {
    super();

    this.state = {
      users: [],
      loading: true,
      error: false
    };
  }

  componentDidMount () {
    this.getApiData();
  }

  // Method to get Data from API
  getApiData = () => {
    ApiFetch(PATHS.API, CONSTANTS.API_METHOD.GET).then(res => {
      const records = this.removeDuplicate(res.data || SampleData);
      const users  = [ ...records ] ;
      const error = res.error || false;
      this.setState({
        users,
        error,
        loading: false
      });
    });
  }

  // Method to remove Duplicates
  removeDuplicate = (arr) => {
    if (arr.length === 0) {
      return [];
    }

    let users = {};
    const newArray = [];

    for (let i in arr) {
      let str = `${arr[i].first_name}_${arr[i].last_name}`;
      if (!users.hasOwnProperty(str)) {
        users[str] = true
        newArray.push(arr[i]);
      }
    }
    users = {};
    return newArray;
  }

  // Method to delete the tiles based on ID
  deleteUser = (userId) => {
    let { users } = this.state;
    users.splice(userId, 1);
    this.setState({
      users
    });
  }

  // Reload the API data
  reloadData = () => {
    this.setState({
      loading: true
    }, () => {
      this.getApiData();
    })
  }

  // Method to disable the Error box
  disableErrorBox = () => this.setState({error: false});

  render () {
    const { loading, users, error } = this.state;
    return (
      <div className="container pearon-users">
        <h1 className="header">Pearson User Management</h1>
        <div className="container-box">
          <button className="reload" value="reload" onClick={this.reloadData} disabled={loading}>Reload</button>
          {
            loading ? <Loader height={50} width={50} />
                 : <DisplayUsers onclick={this.deleteUser} data={users}/>
          }
        </div>
        { error && <ErrorMsg click={this.disableErrorBox} message={error.message || ''}/> }
      </div>
    );
  }
}

export default PearsonUsers;