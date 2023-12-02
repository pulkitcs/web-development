import { Component } from "react";
import { connect } from 'react-redux';
import { add, subtract } from '../redux/actions';

type state = {
  app: {
    counter: {
      value: number,
      type: string,
    }
  }
}

type props = {
  value: number,
  add: () => void,
  subtract: () => void
}

class AppWithClass extends Component<props> {

  constructor(props: props) {
    super(props);
    this.handleClick = this.handleClick.bind(this)
  }

  handleClick(type: string) {
    if(type === '+') {
      this.props.add();
    } else {
      this.props.subtract();
    }
  }

  render() {
    const { value } = this.props;

    return <div>
      <p>This is a class component used in react 18</p>
      <p>This current count {value}</p>
      <button onClick={() => this.handleClick('+')}>Add</button>
      <button onClick={() => this.handleClick('-')}>Subtract</button>
    </div>
  }
}

function mapStateToProps(state: state): { value: number, type: string } {
  const { app: { counter: { value, type } } }: state = state;

  return ({
    value,
    type
  })
}

const mapDispatchToProps = {
  add,
  subtract
}

const withConnect = connect(mapStateToProps, mapDispatchToProps)(AppWithClass)
export default withConnect;