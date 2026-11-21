import React from 'react';
import ERROR_MSG from '../../config/error';
import API_SETTINGS from '../../config/api';
import './MsgBox.css';

const errorMsg = Object.create(ERROR_MSG);
const apiMsg = Object.create(API_SETTINGS);

// Component to render the received API data
const InformationBox = ({routesData}) => (
    <div className="status">
      <p>Total Distance: <strong>{ routesData[0] } Km</strong></p>
      <p>Total Time: <strong>{ routesData[1] } Hrs</strong></p>
    </div>
  );

// Method to check error type and return relevent css class
const errorMessageClass = (msg) => errorMsg.API_SERVER_ERROR === msg || errorMsg.FAILED_TO_FETCH === msg ? 'error' : '';

// Container for error messages and information
const MsgBox = ({msg, routesData}) => {
  return (
    <div>
      { 
        (Boolean(msg) || routesData.length > 0 ) &&
          <div className = 'msg-box'>
            { 
              Boolean(msg) && msg !== apiMsg.MOCK_API.MSG_SUCCESS &&
              <div className="status msg">
                <div className={ errorMessageClass(msg) }>
                  { msg }
                </div>
              </div> 
            }
            { routesData.length > 0 && <InformationBox routesData={routesData} /> }
          </div>
      }
    </div>
  );
}

export default MsgBox;