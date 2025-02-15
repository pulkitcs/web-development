import { applyMiddleware, createStore, combineReducers, compose } from 'redux'
import thunk from 'redux-thunk';
import App from './reducers'

// export default createStore(, {}, compose(,
// applyMiddleware(thunk))
// );

export default compose(applyMiddleware(thunk), window?.__REDUX_DEVTOOLS_EXTENSION__ && window?.__REDUX_DEVTOOLS_EXTENSION__())(createStore)(combineReducers({ app: App }), {});