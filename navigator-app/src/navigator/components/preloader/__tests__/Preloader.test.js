import React from 'react';
import renderer from 'react-test-renderer';
import { shallow } from 'enzyme';
import Preloader from '../preloader';

describe('<Preloader /> component', () => {

  it('should match the snapshot', () => {
    const tree = renderer.create(<Preloader enable={true}/>).toJSON();
    expect(tree).toMatchSnapshot();
  });

  it('should render the HTML', () => {
    const enable = true; // Renders
    const wrapper = shallow(<Preloader enable={enable} />);
    
    expect(wrapper.find('.preloader').length).toBe(1); 
  })

  it('should not render the HTML', () => {
    const enable = false; // Does not render 
    const wrapper = shallow(<Preloader enable={enable} />);
    
    expect(wrapper.find('.preloader').length).toBe(0);
  })
})
