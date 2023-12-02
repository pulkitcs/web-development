import { useDispatch, useSelector } from 'react-redux';
import { add, subtract } from '../redux/actions';

type state = {
  app: {
    counter: {
      value: number,
      type: string,
    }
  }
}

// export default function AppWithHooks(): React.ReactNode {
//   const dispatch = useDispatch();
//   const { value }: { value: number} = useSelector((state) => state?.app?.counter);


//   function handleClick(actionType: string) {
//     if(actionType === '+')
//       dispatch(add());
//     else if(actionType === '-')
//       dispatch(subtract());
//   }

//   return (
//     <div>
//       <div>The current value is {value}</div>
//       <button type="button" onClick={() => handleClick('+')}>Add</button>
//       <button type="button" onClick={() => handleClick('-')}>Subtract</button>
//     </div>
//   );
// }

const AppWithHooks: React.FC = (): React.ReactNode => {
  const dispatch = useDispatch();
  const { value }: { value: number} = useSelector((state: state) => state?.app?.counter);


  function handleClick(actionType: string) {
    if(actionType === '+')
      dispatch(add());
    else if(actionType === '-')
      dispatch(subtract());
  }

  return (
    <div>
      <div>The current value is {value}</div>
      <button type="button" onClick={() => handleClick('+')}>Add</button>
      <button type="button" onClick={() => handleClick('-')}>Subtract</button>
    </div>
  );
}

export default AppWithHooks;