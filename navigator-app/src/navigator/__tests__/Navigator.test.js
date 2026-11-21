import React from 'react';
import renderer from 'react-test-renderer';
import Navigator from '../../navigator';

describe('<Navigator /> component', () => {
  
  it('should match the snapshot', () => {
    const tree = renderer.create(<Navigator />).toJSON();
    expect(tree).toMatchSnapshot();
  })
})