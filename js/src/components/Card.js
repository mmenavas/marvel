import React from 'react';
import PropTypes from 'prop-types';

const Card = props => (
  <div className={"card" + (props.isOn ? " card--on" : "")} onClick={() => props.reveal()}>
    {props.isOn ? 
      <img className="card__image" src={props.image} alt="" />
      :
      "?"}
  </div>
);

Card.propTypes = {
    id: PropTypes.number.isRequired,
    image: PropTypes.string.isRequired,
    isOn: PropTypes.bool.isRequired,
    reveal: PropTypes.func.isRequired
  }

export default Card;
