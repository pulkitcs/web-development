import { INCREASE, DECREASE } from "./actionType";

type initState = {
  counter: {
    value: number,
    type?: string,
  }
}

type action = {
  type: string,
}

const initState: initState = {
  counter: {
    value: 0,
  }
};

export default function (state = initState, action: action): initState {
  const { type }: { type: string } = action;

  switch (type) {
    case INCREASE: {
      return ({
        ...state,
        counter: {
          ...state.counter,
          type: INCREASE,
          value: state.counter.value + 1,
        }
      })
    }

    case DECREASE: {
      return ({
        ...state,
        counter: {
          ...state.counter,
          type: DECREASE,
          value: state.counter.value - 1,
        }
      })
    }

    default:
      return state;
  }
}