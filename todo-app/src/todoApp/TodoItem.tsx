import { useEffect, useState, useCallback, memo } from "react";
import { TodoItemTypes } from "./TodoApp.types";

import styles from "./TodoApp.module.css";

function TodoItem(props: TodoItemTypes) {
  const { deleteItem, editItem, task, index } = props;
  const [item, setItem] = useState<string>(task);
  const [state, setState] = useState<boolean>(false);

  useEffect(() => {
    setItem(task);
  }, [task])

  const handleEdit = useCallback((
    index: number, 
    task:string, 
    item: string, 
    editItem: (index: number, value: string) => void) => {

      if (item !== task && item !== '') {
        editItem(index, item);
      }

      setState(state => !state);
  }, []);

  const handleChange =  useCallback((event: React.ChangeEvent<HTMLInputElement>) => {
    const text = event.target.value.trim();
    setItem(text);
  }, [])

  return <div className={styles.taskContainer}>
    <input type='text' readOnly={!state} className={styles.label} onChange={handleChange} value={item} title={item} />
    <button className={styles.delete} onClick={() => deleteItem(index)}>Delete</button>
    <button className={styles.edit} onClick={() => handleEdit(index, task, item, editItem)}>{state ? 'Confirm Edit' : 'Edit'}</button>
  </div>
}


export default memo(TodoItem);