import React, { Component } from 'react';
import MsgBox from '../msgBox';
import InputControl from '../inputControl';
import Preloader from '../preloader'
import { sendRoutes, fetchRoutes } from '../../services/navigator';
import API_SETTINGS from '../../config/api';
import ERROR_MSG from '../../config/error';
import PropTypes from 'prop-types';
import './SearchForm.css';

class SearchForm extends Component {

  constructor() {
    super();
  
    this.state = {
      loading: false,
      msg: '',
      routesData: [],
      formData: {
        startLocation: null,
        dropLocation: null
      }
    }
  
    this.apiConfig = Object.create(API_SETTINGS.MOCK_API);
    this.msg = Object.create(ERROR_MSG);
  }

  // Method for handling the states for the input controls
  ctrlValueChange = (e) => {
    const {name, value} = e;

    this.setState((prev) => ({
      formData: {...prev.formData, [name]:value}
    }));
  }

  // Method to toggle the preloader
  togglePreloader = (value) => this.setState({loading: value});

  // Method to check the form values
  handleSubmit = () => {
    this.clearMsgNRoutes();
    this.props.clearMapDirection();
  
    const {formData} = this.state;
    this.submitRoute(formData);
  }

  // Method to submit Route to the mock API and get access token
  submitRoute = async (startDrop) => {
    this.togglePreloader(true);

    let result = await sendRoutes({startDrop}).catch(e => {
      result = e;
      this.setState({ msg: e.message || this.msg.API_SERVER_ERROR });
    });

    if(result.token) {
      this.getRoutes(result);
    } else {
      this.setState({ msg: result.message || this.msg.API_SERVER_ERROR });
      this.togglePreloader(false);
    }

  }
  
  // Method to check the access token and then request for user cordinates
  getRoutes = async (key) => {
    let res = await fetchRoutes(key.token).catch(e => {
      res = e;
    })

    this.togglePreloader(false);
    
    this.checkResponse(res);
  } 

  // Method to return the Api responses and route details { distance and time }
  checkResponse = (res) => {
    let msg = this.msg.API_SERVER_ERROR;
    let routesData = [];

    if (res) {
      switch(res.status) {
        case(this.apiConfig.MSG_SUCCESS): {
          routesData = [res.total_distance, res.total_time];
          msg = res.status;
          this.props.mapCoordinates(res.path);
          break;
        }
        default: {
          msg = res.message || res.error || res.status || this.msg.API_SERVER_ERROR;
          break;
        }
      }
    }

    this.setState({ 
      msg,
      routesData 
    });
  }

  // Method to clear msg box and the current generated Google Map route 
  clearMsgNRoutes = () => {
    const routesData = [];
    const msg = '';
      this.setState({
      routesData,
      msg
    });
  }
  
  // Method to clear all form fields
  resetForm = () => {
    this.props.clearMapDirection();
    this.clearMsgNRoutes();
    this.setState(() => ({
      formData: {
        startLocation: null,
        dropLocation: null
      }
    }))
  }

  // Method returns boolean for checking empty startLocation and dropLocation 
  isSubmitEnable = () => {
    const {dropLocation, startLocation} = this.state.formData;
    return startLocation && dropLocation;
  }
  
  render() {
    const { loading, msg, routesData, formData } = this.state;
    const isSubmitDisable = !this.isSubmitEnable();

    return (
      <div className='input-container'>
        <Preloader enable = {loading} />
        <InputControl name="startLocation" label="Start Location" value={formData.startLocation} ctrlValueChange={this.ctrlValueChange}/>
        <InputControl name="dropLocation" label="Drop off Location" value={formData.dropLocation} ctrlValueChange={this.ctrlValueChange}/>
        <MsgBox msg={msg} routesData={routesData} />
        <div className='clear'></div>
        <div className="form-control">
          <button disabled={isSubmitDisable} className="btn" onClick={this.handleSubmit}>Submit</button> 
          <button onClick={this.resetForm} className="btn">Reset</button>
        </div>
      </div>
    );
  }
}

export default SearchForm;

SearchForm.propTypes = {
  "mapCoordinates": PropTypes.func,
  "clearMapDirection": PropTypes.func
}


