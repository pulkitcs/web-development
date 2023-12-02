import { INCREASE, DECREASE } from "./actionType";

type AddMinus = {
  type: string;
}

export function add() {
  // return ({
  //   type: INCREASE,
  // })

  return async (dispatch) => {
    dispatch({
      type: INCREASE,
    })
  }
}

export function subtract(): AddMinus {
  return ({
    type: DECREASE
  })
}