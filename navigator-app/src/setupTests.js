import Enzyme from 'enzyme';
import Adapter from 'enzyme-adapter-react-16';

// Configure Enzyme adapter for Jest
Enzyme.configure({ adapter: new Adapter() });