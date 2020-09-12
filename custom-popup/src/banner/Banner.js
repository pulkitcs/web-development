import React from 'react'
import PropTypes from 'prop-types';
import SubscriptionImage from './imgs/Subscription.jpg';

import './BannerStyles.css'

const Banner = ({ handlePopupClose, onClick }) => {
  // handleOnClick() is injected from the popups
  const handleOnClick = () => {
    handlePopupClose();
    onClick();
  }

  return (
    <div className="bannerContainer">
      <img src={SubscriptionImage} width="50%" height="auto" alt="Subscription" />
      <p>Join the <strong>1,100,000</strong> subscriber and get an article just like this twice a week.</p>
      <button className="button" onClick={handleOnClick}>SUBSCRIBE</button>
      <p className="policy"><i>No ads, No sales pitch, click to subscribe only.</i></p>
    </div>
  );
}

export default Banner;

Banner.propTypes = {
  handlePopupClose: PropTypes.func.isRequired,
  onClick: PropTypes.func,
}

Banner.defaultProps = {
  onClick: () => null,
}
