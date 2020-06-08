import React from 'react';
import renderer from 'react-test-renderer';
import { mount } from 'enzyme';
import MsgBox from '../msgBox';

describe('<MsgBox /> component', () => {

  const text = 'Rendering';

  it('should match the snapshot', () => {
    const tree = renderer.create(<MsgBox msg={text} routesData={[1,2]}/>).toJSON();
    expect(tree).toMatchSnapshot();
  });

  it('should render the HTML Correctly', () => {
    const wrapper = mount(<MsgBox msg={text} routesData={[1,2]}/>);
    
    expect(wrapper.find('.status').length).toBe(2);
  })

  it('should render the HTML Correctly, when routesData [] is empty', () => {
    const wrapper = mount(<MsgBox msg={text} routesData={[]} />);
    
    expect(wrapper.find('.status').length).toBe(1);
    expect(wrapper.find('.status').text()).toBe(text);
  })
})