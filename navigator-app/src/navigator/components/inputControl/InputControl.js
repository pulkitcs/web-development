import React, { Component } from 'react';
import { gmap } from '../../services/maps';
import './InputControl.css';

class InputControl extends Component {

  inputCtrl;

  constructor(props) {
    super(props);
    this.inputCtrlRef = React.createRef();
  }


  // Method to initialize the Google maps Autocomplete library
  initializeAutocomplete = async() => {
    const { gmap } = this.props;
    const map = await gmap();

    this.inputCtrl = new map.places.Autocomplete(this.inputCtrlRef.current);
    
    // Adding the eventlistener for place_change to google Autocomplete
    this.inputCtrl.addListener('place_changed', e => {
      const places = this.inputCtrl.getPlace();
      if(places) {
        this.props.ctrlValueChange({name: this.props.name, value: places})
      }
    });
  }

  componentDidMount() {
    this.initializeAutocomplete();
  }

  componentDidUpdate() {
    if(!this.props.value) {
      this.inputCtrlRef.current.value = '';
    };
  }

  // Method for detecting empty values and updating the props onChange event
  handleOnChange = (e) => {
    if(e.target.value.trim() === '') {
      this.props.ctrlValueChange({name: this.props.name, value: null})
    }
  }

  render() {
    return (
      <div className='rows'>
          <p>{this.props.label}</p>
          <input
            className="input-control"
            type="text" 
            ref={this.inputCtrlRef}
            name={this.props.name}
            onChange={this.handleOnChange}
          />
      </div>
    );
  } 
}

export default InputControl;

InputControl.defaultProps = {
  gmap
}