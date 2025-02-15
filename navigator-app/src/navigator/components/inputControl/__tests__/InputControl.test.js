import React from 'react';
import renderer from 'react-test-renderer';
import { shallow } from 'enzyme';
import InputControl from '../inputControl';

describe('<InputControl /> component', () => {

  it('should match the snapshot', () => {
    const tree = renderer.create(<InputControl />).toJSON();
    expect(tree).toMatchSnapshot();
  });

  it('should render the HTML Correctly', () => {
    const wrapper = shallow(<InputControl />);
    
    expect(wrapper.find('input').length).toBe(1);
  });
})