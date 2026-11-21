import React, { Component } from 'react';

interface iProp {}
interface iState {
    value: number;
}

class App extends Component<iProp, iState> {
    constructor(props: iProp) {
        super(props);
        this.state = {
            value: 0,
        }
    }

    render() {
        const {value} = this.state;

        return <button type="button" onClick={() => {
            this.setState((prev: iState) => ({
                ...prev,
                value: prev.value + 1,
            }))
        }}>Click Me {value}</button>;
    }
}

export default App;