import React from 'react';
import renderer from 'react-test-renderer';
import SearchForm from '../searchForm';

describe('<SearchForm /> component', () => {

  it('should match the snapshot', () => {
    const tree = renderer.create(<SearchForm />).toJSON();
    expect(tree).toMatchSnapshot();
  })
})